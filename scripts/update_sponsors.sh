#!/usr/bin/env bash
# update_sponsors.sh - Download and normalize sponsor images for a SCaLE event.
#
# Usage:
#   ./scripts/update_sponsors.sh <event-id>
#   ./scripts/update_sponsors.sh 24x
#
# Requires: curl, jq, mogrify (ImageMagick)
#
# Fetches sponsor data from socallinuxexpo.org, clears pkg/sponsor/images/,
# downloads each logo, and normalizes it to 220x220 with a white background.
#
# After running:
#   1. Update pkg/sponsor/gold.go, platinum.go, and diamond.go with the new filenames
#   2. Run: go test ./pkg/sponsor/...
#   3. Rebuild the binary (images are embedded at compile time)
set -euo pipefail

if [ $# -ne 1 ]; then
    echo "Usage: $0 <event-id>" >&2
    echo "Example: $0 23x" >&2
    exit 1
fi

EVENT_ID="$1"
BASE_URL="https://www.socallinuxexpo.org"
JSON_URL="${BASE_URL}/rest/sponsor/${EVENT_ID}/json"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
IMAGE_DIR="${SCRIPT_DIR}/../pkg/sponsor/images"

# Check dependencies
for cmd in curl jq mogrify; do
    if ! command -v "$cmd" &>/dev/null; then
        echo "Error: $cmd is required but not found" >&2
        exit 1
    fi
done

mkdir -p "$IMAGE_DIR"

echo "Fetching sponsor data from ${JSON_URL}..."
JSON=$(curl -sf "$JSON_URL") || {
    echo "Error: failed to fetch sponsor JSON" >&2
    exit 1
}

# Clear existing images
rm -f "${IMAGE_DIR}"/*

COUNT=0
echo "$JSON" | jq -c '.[]' | while IFS= read -r entry; do
    SPONSOR=$(echo "$entry" | jq -r '.sponsor')
    LOGO_URL=$(echo "$entry" | jq -r '.logo_url')

    if [ -z "$LOGO_URL" ] || [ "$LOGO_URL" = "null" ]; then
        echo "Skipping ${SPONSOR}: no logo_url"
        continue
    fi

    # Build filename: lowercase, remove non-alphanumeric (keep dots for extension)
    EXT="${LOGO_URL##*.}"
    EXT=$(echo "$EXT" | tr '[:upper:]' '[:lower:]')
    FILENAME=$(echo "$SPONSOR" | tr '[:upper:]' '[:lower:]' | tr -cd 'a-z0-9')
    OUTFILE="${IMAGE_DIR}/${FILENAME}.${EXT}"

    FULL_URL="${BASE_URL}${LOGO_URL}"
    echo "Downloading ${SPONSOR} -> ${FILENAME}.${EXT}"

    if ! curl -sf -o "$OUTFILE" "$FULL_URL"; then
        echo "  Warning: failed to download ${FULL_URL}" >&2
        rm -f "$OUTFILE"
        continue
    fi

    mogrify -resize 200x220 -background white -gravity center -extent 220x220 "$OUTFILE"
    COUNT=$((COUNT + 1))
done

echo "Done. Processed sponsor images into ${IMAGE_DIR}"
