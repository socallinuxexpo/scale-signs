{ inputs }:

let
  systems = [
    "x86_64-linux"
    "aarch64-linux"
  ];
in
inputs.nixpkgs.lib.genAttrs systems
  (
    system:
    let
      pkgs = inputs.nixpkgs.legacyPackages.${system};
      lib = pkgs.lib;
      defaultPackages = import ./default-pkgs.nix { inherit pkgs; };

      # prefetch-npm-deps react-display/package-lock.json
      npmDeps = pkgs.fetchNpmDeps {
        src = builtins.path { path = ../react-display; };
        hash = "sha256-M4/nzZR7n+ZDznn+a0NDYJsjmaaJNqJjt08ppHF1LPc=";
      };

      goSumSha = "sha256-/P+jK3JCT7SAQWiYZCVo1hXYpBq35xoDfwm3S1Ly8rE=";

      commonCheckPhase = ''
        # point npm at the offline cache
        export npm_config_cache=${npmDeps}

        # React lint
        cd react-display
        npm ci --no-fund --cache="$npm_config_cache" --prefer-offline --no-audit --progress=false
        node node_modules/.bin/eslint . --max-warnings=0
        cd ..

        # Go tests
        export CGO_ENABLED=1
        export XDG_CACHE_HOME=$TMPDIR
        mkdir -p $XDG_CACHE_HOME/staticcheck
        staticcheck ./...
        # avoid race detection for aarch64
        # https://github.com/golang/go/issues/29948
        if [ "${system}" != "aarch64-linux" ]; then
          go test --count=1 --race -v ./...
        else
          go test --count=1 -v ./...
        fi
      '';

      reactBuild = ''
        # point npm at the offline cache
        export npm_config_cache=${npmDeps}

        # build the React bundle
        cd react-display
        npm ci --no-fund --cache="$npm_config_cache" --prefer-offline --no-audit --progress=false

        # invoke tsc & vite via node
        node node_modules/.bin/tsc -b
        node node_modules/.bin/vite build
        cd ..
      '';

    in
    {
      scale-simulator = pkgs.buildGoModule rec {
        pname = "scale-simulator";
        version = "unstable";
        src = builtins.path { path = ../.; };
        goPackagePath = "github.com/kylerisse/go-signs";
        vendorHash = goSumSha;
        nativeBuildInputs = defaultPackages ++ [ npmDeps ];

        checkPhase = commonCheckPhase;

        buildPhase = lib.strings.concatStrings [
          reactBuild
          ''
            mkdir -p out
            go build -o out/scale-simulator cmd/scale-simulator/main.go
          ''
        ];

        installPhase = ''
          mkdir -p $out/bin/
          cp out/scale-simulator $out/bin/
        '';

        meta = with lib; {
          description = "SCaLE Schedule Simulator";
          license = licenses.mit;
          maintainers = [ "kylerisse" ];
          mainProgram = "scale-simulator";
        };
      };

      go-signs = pkgs.buildGoModule rec {
        pname = "go-signs";
        version = "unstable";
        src = builtins.path { path = ../.; };
        goPackagePath = "github.com/kylerisse/go-signs";
        vendorHash = goSumSha;
        nativeBuildInputs = defaultPackages ++ [ npmDeps ];

        checkPhase = commonCheckPhase;

        buildPhase = lib.strings.concatStrings [
          reactBuild
          ''
            mkdir -p out
            go build -o out/go-signs cmd/go-signs/main.go
          ''
        ];

        installPhase = ''
          mkdir -p $out/bin/
          cp out/go-signs $out/bin/
        '';

        meta = with lib; {
          description = "SCaLE Digital Signage App";
          license = licenses.mit;
          maintainers = [ "kylerisse" ];
          mainProgram = "go-signs";
        };
      };

      go-signs-ci-release = pkgs.buildGoModule rec {
        pname = "go-signs-ci";
        version = "release";
        src = builtins.path { path = ../.; };
        goPackagePath = "github.com/kylerisse/go-signs";

        vendorHash = goSumSha;

        nativeBuildInputs = defaultPackages ++ [ npmDeps ];

        # run both lint/tests and the React build before the go build
        checkPhase = commonCheckPhase;

        targets = [
          "linux/amd64"
          "linux/arm64"
        ];

        # custom buildPhase: React → cross‑compile Go
        buildPhase = lib.strings.concatStrings [
          reactBuild
          ''
            # cross‑compile every GOOS/GOARCH
            export CGO_ENABLED=0
            mkdir -p out
            for arch in ${lib.concatStringsSep " " targets}; do
              IFS="/" read goos goarch <<< "$arch"
              echo "→ building go-signs for $goos/$goarch"
              GOOS=$goos GOARCH=$goarch go build \
                -o out/go-signs-$goos-$goarch \
                cmd/go-signs/main.go

              echo "→ building scale-simulator for $goos/$goarch"
              GOOS=$goos GOARCH=$goarch go build \
                -o out/scale-simulator-$goos-$goarch \
                cmd/scale-simulator/main.go
            done
          ''
        ];

        installPhase = ''
          # copy all cross-compiled versions
          mkdir -p $out
          for f in out/*; do
            cp "$f" $out/
          done
          cd $out && sha256sum * > checksums.txt
        '';

        meta = with lib; {
          description = "go-signs CI release";
          license = licenses.mit;
          maintainers = [ "kylerisse" ];
        };
      };
    }
  )
