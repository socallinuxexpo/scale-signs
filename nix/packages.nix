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
        hash = "sha256-ii2Dvdrfw7oXHU+yluYW1E416P2cLC0Xb7h8Nn8OFAg=";
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
        version = "0.2.0";
        src = builtins.path { path = ../.; };
        goPackagePath = "github.com/socallinuxexpo/scale-signs";
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

      scale-signs = pkgs.buildGoModule rec {
        pname = "scale-signs";
        version = "0.2.0";
        src = builtins.path { path = ../.; };
        goPackagePath = "github.com/socallinuxexpo/scale-signs";
        vendorHash = goSumSha;
        nativeBuildInputs = defaultPackages ++ [ npmDeps ];

        checkPhase = commonCheckPhase;

        buildPhase = lib.strings.concatStrings [
          reactBuild
          ''
            mkdir -p out
            go build -o out/scale-signs cmd/scale-signs/main.go
          ''
        ];

        installPhase = ''
          mkdir -p $out/bin/
          cp out/scale-signs $out/bin/
        '';

        meta = with lib; {
          description = "SCaLE Digital Signage App";
          license = licenses.mit;
          maintainers = [ "kylerisse" ];
          mainProgram = "scale-signs";
        };
      };

      scale-signs-ci-release = pkgs.buildGoModule rec {
        pname = "scale-signs-ci";
        version = "release";
        src = builtins.path { path = ../.; };
        goPackagePath = "github.com/socallinuxexpo/scale-signs";

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
              echo "→ building scale-signs for $goos/$goarch"
              GOOS=$goos GOARCH=$goarch go build \
                -o out/scale-signs-$goos-$goarch \
                cmd/scale-signs/main.go

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
          description = "scale-signs CI release";
          license = licenses.mit;
          maintainers = [ "kylerisse" ];
        };
      };
    }
  )
