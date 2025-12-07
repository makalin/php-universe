# WebAssembly Calculator Example

A calculator application that runs entirely in the browser using PHP compiled to WebAssembly.

## Features

- Basic arithmetic operations (add, subtract, multiply, divide)
- Power and square root functions
- Error handling for edge cases
- Clean, modern web interface
- No server required - runs 100% client-side

## Usage

### Build the WASM Module

```bash
cd examples/wasm-calculator
composer install
px build --target=wasm
```

### Test Locally

```bash
# Build native version for testing
px build --target=native
./dist/calculator add 10 5
# Output: Result: 15

# Serve the HTML file (WASM requires HTTP server)
python3 -m http.server 8000
# Or use any HTTP server
# Then open http://localhost:8000/index.html
```

### Deploy

1. Build the WASM module: `px build --target=wasm`
2. Copy `dist/calculator.wasm` and `index.html` to your web server
3. Ensure your server serves `.wasm` files with correct MIME type: `application/wasm`

## Files

- `src/calculator.php` - Calculator logic with WASM exports
- `index.html` - Web interface
- `universe.toml` - Build configuration
- `composer.json` - PHP dependencies

## Browser Compatibility

- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support (Safari 11+)

