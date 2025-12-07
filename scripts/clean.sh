#!/bin/bash

# Clean Script
# Removes build artifacts and temporary files

set -e

echo "🧹 Cleaning build artifacts..."

# Remove dist directory
if [ -d "dist" ]; then
    echo "Removing dist/..."
    rm -rf dist/
fi

# Remove vendor directory (optional, uncomment if needed)
# if [ -d "vendor" ]; then
#     echo "Removing vendor/..."
#     rm -rf vendor/
# fi

# Remove compiled files
find . -name "*.wasm" -type f -delete
find . -name "*.o" -type f -delete
find . -name "*.a" -type f -delete

# Remove cache files
find . -name ".phpunit.result.cache" -type f -delete

echo "✅ Clean complete!"

