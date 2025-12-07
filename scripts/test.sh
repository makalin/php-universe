#!/bin/bash

# Test Script
# Runs tests for the project

set -e

echo "🧪 Running tests..."

# Check if tests directory exists
if [ ! -d "tests" ]; then
    echo "⚠️  No tests directory found. Creating one..."
    mkdir -p tests
    echo "<?php" > tests/ExampleTest.php
    echo "// Add your tests here" >> tests/ExampleTest.php
    exit 0
fi

# Check if PHPUnit is available
if command -v vendor/bin/phpunit &> /dev/null; then
    vendor/bin/phpunit tests/
elif command -v phpunit &> /dev/null; then
    phpunit tests/
else
    echo "⚠️  PHPUnit not found. Install with: composer require --dev phpunit/phpunit"
    echo "Running basic syntax check instead..."
    find src -name "*.php" -exec php -l {} \;
fi

echo "✅ Tests complete!"

