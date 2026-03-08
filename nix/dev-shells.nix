{ inputs }:

let
  systems = [
    "x86_64-linux"
    "aarch64-darwin"
  ];
in
inputs.nixpkgs.lib.genAttrs systems
  (
    system:
    let
      pkgs = inputs.nixpkgs.legacyPackages.${system};
      defaultPackages = (import ./default-pkgs.nix) { inherit pkgs; };
    in
    {
      default = pkgs.mkShellNoCC {
        packages = defaultPackages;
      };
    }
  )
