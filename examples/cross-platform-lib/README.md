# Cross-Platform Library Example

A math library that demonstrates how to write code that works across all php-universe targets:
- Native binaries
- WebAssembly
- iOS applications
- Embedded devices

## Features

- Fibonacci sequence calculation
- Factorial calculation
- GCD (Greatest Common Divisor)
- LCM (Least Common Multiple)
- Prime number checking
- Prime number generation

## Usage

### Native Binary

```bash
cd examples/cross-platform-lib
composer install
px build --target=native

# Test
./dist/math-lib fibonacci 10
./dist/math-lib factorial 5
./dist/math-lib gcd 48 18
./dist/math-lib is_prime 17
```

### WebAssembly

```bash
px build --target=wasm
# Use the generated .wasm file in your web application
```

### iOS

```bash
px build --target=ios
# Import the generated framework into your iOS project
```

### Embedded

```bash
px build --target=embedded
# Flash to your ESP32 or RP2040 device
```

## Key Points

This example demonstrates:
- **Platform-agnostic code** - No platform-specific conditionals
- **Pure functions** - No file I/O or system calls
- **Error handling** - Graceful error handling that works everywhere
- **Function exports** - Properly exported functions for WASM/iOS

## Files

- `src/MathLib.php` - Math library implementation
- `universe.toml` - Configuration for all targets
- `composer.json` - PHP dependencies

