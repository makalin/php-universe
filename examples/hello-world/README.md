# Hello World Example

The simplest possible php-universe application.

## Quick Start

```bash
cd examples/hello-world
composer install
px build --target=native
./dist/hello-world "PHP Universe"
```

## What This Example Shows

- Basic PHP functions
- CLI entry point detection
- Simple function exports for WASM
- Minimal configuration

## Building for Different Targets

```bash
# Native binary
px build --target=native
./dist/hello-world

# WebAssembly
px build --target=wasm
# Then use the generated .wasm file in your web app
```

## Files

- `src/main.php` - Main application code
- `universe.toml` - Build configuration
- `composer.json` - PHP dependencies

