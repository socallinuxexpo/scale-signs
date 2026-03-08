# Releases

This project leverages [Scaled Trunk-Based Development](https://trunkbaseddevelopment.com/#scaled-trunk-based-development). Developers work on feature branches and submit [Pull Requests](https://github.com/kylerisse/go-signs/pulls) against the `master` branch to contribute to the `unstable` version of `go-signs`.

## Versions

[Semantic Versioning](https://semver.org/) is used for tracking releases with one major modification. Any pre-1.0 release can have breaking `MINOR` version changes. For example, `0.2.0` is a breaking change from `0.1.0`. This is to maintain maximum flexibility during early development while providing a stability guarantee. `PATCH` versions are standard at all times. Once `1.0` is released, semver will be strictly enforced.

## Release Process

To be performed by maintainers

1. Create a `release/x.x` branch off of `master`
1. Create a version commit directly to the release branch. (Example for `0.1.0` from [release/0.1](https://github.com/kylerisse/go-signs/commit/7415c17d05c03e9fb128b65b9bd0ad10197fcd22) branch). These commits exist to version the nix package and corresponding react application and corresponding NPM hash.
1. Create a tag against the release branch. (Example `0.1.0`)
1. Run `nix run .#go-signs-ci-release`.
1. Upload all artifacts from `result/` to the GitHub releases page.

## Hotfix Process

1. Develop the fix as normal and merge via PR to the `master` branch.
1. Cherry pick the corresponding fix commits to the `release/x.x` branch.
1. Create a version commit directly to the release branch. (Example `0.1.1`)
1. Create a tag against the release branch. (Example `0.1.1`)
1. Upload all artifacts from `result/` to the GitHub releases page.
