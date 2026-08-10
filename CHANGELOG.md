# Changelog

All notable changes to `arcdev-packages/core` are documented here. Format based on [Keep a Changelog](https://keepachangelog.com/); this project adheres to Semantic Versioning.

## [1.0.1] - 2026-08-10

### Fixed
- `MyBaseModel::uploadImage()` and `MyBaseModel::createThumbnail()` now force `0644` on the final written image (via `@chmod` on the resolved absolute path, immediately after the `put()`). Previously they relied solely on the `local` disk's `'public'` visibility, which did not reliably set world-readable permissions on Linux/Plesk production — uploaded images (e.g. a consuming project's welcome-page header logo) were written but the web server could not serve them, appearing broken/blank. **Only affects new uploads; pre-existing files on production keep their current permissions until re-uploaded or chmod'd once.**

## [1.0.0]

- Baseline (pre-versioning production state).
