#!/bin/bash

# Build All Script
# Builds the project for all enabled targets

set -e

echo "🔨 Building for all enabled targets..."

# Check if universe.toml exists
if [ ! -f "universe.toml" ]; then
    echo "❌ Error: universe.toml not found"
    exit 1
fi

# Check if px is available
if ! command -v px &> /dev/null; then
    echo "❌ Error: px command not found. Install with: composer global require makalin/php-universe"
    exit 1
fi

# Build for each target
TARGETS=("native" "wasm" "ios" "embedded")

for target in "${TARGETS[@]}"; do
    if grep -q "\[targets\.$target\]" universe.toml && grep -A 1 "\[targets\.$target\]" universe.toml | grep -q "enabled = true"; then
        echo ""
        echo "📦 Building for $target..."
        px build --target=$target || echo "⚠️  Warning: Build for $target failed"
    else
        echo "⏭️  Skipping $target (not enabled)"
    fi
done

echo ""
echo "✅ Build complete!"

