# Examples

This directory contains working examples demonstrating how to use php-universe to build applications for different platforms.

## Available Examples

### 1. [Hello World](hello-world/)
The simplest possible php-universe application. Perfect for getting started.

**What it demonstrates:**
- Basic PHP functions
- CLI entry point
- Simple configuration

**Run it:**
```bash
cd hello-world
composer install
px build --target=native
./dist/hello-world "PHP Universe"
```

---

### 2. [CLI Tool](cli-tool/)
A command-line file processor that analyzes files and works as a native binary.

**What it demonstrates:**
- File I/O operations
- Error handling
- CLI argument parsing
- Formatted output

**Run it:**
```bash
cd cli-tool
composer install
px build --target=native
./dist/file-processor README.md
```

---

### 3. [WASM Calculator](wasm-calculator/)
A calculator that runs entirely in the browser using WebAssembly.

**What it demonstrates:**
- WebAssembly compilation
- Function exports
- Browser integration
- Error handling

**Run it:**
```bash
cd wasm-calculator
composer install
px build --target=wasm
# Serve index.html with an HTTP server
python3 -m http.server 8000
# Open http://localhost:8000/index.html
```

---

### 4. [Cross-Platform Library](cross-platform-lib/)
A math library that works on all platforms (Native, WASM, iOS, Embedded).

**What it demonstrates:**
- Platform-agnostic code
- Pure functions
- Multi-target compilation
- Library design

**Run it:**
```bash
cd cross-platform-lib
composer install
px build --target=native
./dist/math-lib fibonacci 10
```

---

## Getting Started

1. **Choose an example** that matches what you want to build
2. **Navigate to the example directory**
3. **Install dependencies**: `composer install`
4. **Build for your target**: `px build --target=<target>`
5. **Run and test**: Follow the example's README

## Building for Different Targets

Each example includes a `universe.toml` configuration file. You can enable/disable targets as needed:

```bash
# Build for native
px build --target=native

# Build for WebAssembly
px build --target=wasm

# Build for iOS (requires macOS/Xcode)
px build --target=ios

# Build for embedded device
px build --target=embedded

# Build all enabled targets
px build --all
```

## Project Structure

Each example follows this structure:

```
example-name/
├── src/              # Source code
│   └── *.php        # PHP files
├── universe.toml    # Build configuration
├── composer.json     # PHP dependencies
├── README.md         # Example-specific documentation
└── dist/             # Build output (generated)
```

## Next Steps

- Read the [main README](../README.md) for overview
- Check [TOOLS.md](../TOOLS.md) for tool documentation
- See [EXAMPLES.md](../EXAMPLES.md) for more code examples
- Review [CONTRIBUTING.md](../CONTRIBUTING.md) to contribute

---

**Have questions?** Open an issue on GitHub or check the documentation files.

