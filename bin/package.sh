#!/usr/bin/env bash
# Builds an installable theme zip from committed files only:
#   dist/shortlaxi-<version>.zip  (contains a single top-level shortlaxi/ folder)
# Usage: bin/package.sh [git-ref]   (default: HEAD)
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
REF="${1:-HEAD}"
cd "$ROOT"

php bin/validate.php shortlaxi

VERSION="$(git show "$REF:shortlaxi/style.css" | sed -n 's/^Version:[[:space:]]*//p' | tr -d '\r')"
mkdir -p dist
OUT="dist/shortlaxi-${VERSION}.zip"
git archive --format=zip --prefix=shortlaxi/ -o "$OUT" "$REF:shortlaxi"
echo "Built $OUT"
