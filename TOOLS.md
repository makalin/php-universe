# PHP Tools Ecosystem

This document provides comprehensive documentation for all PHP tools in the php-universe ecosystem. Each tool is designed to extend PHP beyond traditional web development, enabling compilation to native binaries, mobile apps, WebAssembly, embedded systems, and more.

---

## Core Compilation Engines

### php2ir
**Repository:** [github.com/makalin/php2ir](https://github.com/makalin/php2ir)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
An ahead-of-time (AOT) compilation pipeline that translates PHP 8.x code directly into LLVM Intermediate Representation (LLVM-IR), bypassing the traditional C intermediate step. This enables the generation of native executables in formats such as ELF (Linux), EXE (Windows), and Mach-O (macOS), eliminating VM overhead and producing standalone binaries.

**Key Features:**
- Direct PHP 8.x to LLVM-IR compilation
- Native binary generation (no PHP runtime required)
- Cross-platform support (Linux, macOS, Windows)
- Optimized performance with LLVM optimization passes
- FFI support for C library integration

**Use Cases:**
- CLI tools and system utilities
- High-performance microservices
- Desktop applications
- Daemons and background services

**Example Usage:**
```bash
php2ir compile src/main.php --output=app --optimize=O3
./app
```

---

### php-ios
**Repository:** [github.com/makalin/php-ios](https://github.com/makalin/php-ios)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A Swift Package Manager (SwiftPM) wrapper that embeds a static PHP runtime into iOS applications. This allows PHP scripts to run natively on iPhone and iPad devices without requiring a server, making it ideal for offline logic, templating, migrations, or business logic that needs to run on-device.

**Key Features:**
- Static PHP runtime embedded in iOS apps
- Full App Store compliance
- Clean Swift API (`PhpEngine`)
- Support for inline code, bundled scripts, and JSON I/O
- Sandboxed resource access
- No server required

**Use Cases:**
- Offline mobile applications
- On-device data processing
- Template rendering in iOS apps
- Migration scripts
- Business logic execution

**Example Usage:**
```swift
import PhpEngine

let engine = PhpEngine()
let result = try engine.eval("<?php return 2 + 2;")
print(result) // 4
```

---

### php2wasm
**Repository:** [github.com/makalin/php2wasm](https://github.com/makalin/php2wasm)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
Compiles PHP code to WebAssembly (WASM) using Emscripten, enabling PHP to run in browsers, Cloudflare Workers, and other WASM-compatible environments. This brings PHP's server-side capabilities to client-side execution, reducing server load and enabling offline functionality.

**Key Features:**
- PHP to WebAssembly compilation via Emscripten
- Browser execution support
- Cloudflare Workers compatibility
- Sandboxed execution environment
- Function export capabilities
- Reduced server-side processing

**Use Cases:**
- Client-side data processing
- Browser-based applications
- Edge computing (Cloudflare Workers)
- Offline web applications
- Performance-critical client-side operations

**Example Usage:**
```bash
php2wasm compile src/processor.php --output=processor.wasm --export=process_data
```

```javascript
// In browser
const wasmModule = await WebAssembly.instantiateStreaming(fetch('processor.wasm'));
const result = wasmModule.instance.exports.process_data(input);
```

---

### microphp
**Repository:** [github.com/makalin/microphp](https://github.com/makalin/microphp)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A compact PHP runtime (approximately 1-2 MB) embedded directly into firmware, targeting devices like ESP32 (using ESP-IDF) and Raspberry Pi Pico / RP2040 (using Pico SDK). This facilitates IoT scripting without the need for a Linux environment, enabling PHP development in resource-constrained embedded systems.

**Key Features:**
- Ultra-lightweight runtime (~1-2 MB)
- ESP32 support (ESP-IDF)
- Raspberry Pi Pico / RP2040 support (Pico SDK)
- Direct firmware embedding
- No Linux kernel required
- Real-time capable

**Use Cases:**
- IoT device programming
- Embedded system scripting
- Sensor data processing
- Hardware control
- Edge computing on microcontrollers

**Example Usage:**
```bash
microphp build src/iot_script.php --platform=esp32 --output=firmware.bin
```

---

## Supporting Libraries & Tools

### phastron
**Repository:** [github.com/makalin/phastron](https://github.com/makalin/phastron)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
High-performance AST (Abstract Syntax Tree) and data structures library optimized for compiled PHP. Provides efficient implementations of common data structures and AST manipulation utilities that work seamlessly across all compilation targets.

**Key Features:**
- Optimized AST manipulation
- High-performance data structures
- Cross-platform compatibility
- Memory-efficient implementations
- Designed for compiled PHP targets

**Use Cases:**
- AST transformation and analysis
- Code generation tools
- Static analysis
- Compiler internals
- Performance-critical applications

---

### php-embeddings
**Repository:** [github.com/makalin/php-embeddings](https://github.com/makalin/php-embeddings)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A PHP library for working with vector embeddings and similarity search. Enables AI/ML capabilities in PHP applications, including semantic search, recommendation systems, and vector database operations.

**Key Features:**
- Vector embedding generation
- Similarity search algorithms
- Vector database integration
- Semantic search capabilities
- AI/ML model integration

**Use Cases:**
- Semantic search applications
- Recommendation systems
- AI agents and chatbots
- Document similarity matching
- Vector-based data processing

**Example Usage:**
```php
use PhpEmbeddings\VectorDB;

$vec = VectorDB::embed("Hello, world!");
$similar = VectorDB::search($vec, $database, threshold: 0.85);
```

---

### php-querylang
**Repository:** [github.com/makalin/php-querylang](https://github.com/makalin/php-querylang)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A fluent query builder library for PHP that provides SQL-like syntax for querying various data sources. Supports in-memory data structures, databases, and custom data sources with a clean, expressive API.

**Key Features:**
- Fluent query builder API
- SQL-like syntax
- Multiple data source support
- In-memory querying
- Type-safe operations

**Use Cases:**
- In-memory data querying
- Database abstraction
- Data transformation pipelines
- Complex filtering and aggregation
- API query builders

**Example Usage:**
```php
use QueryLang\Query;

$results = Query::select('*')
    ->from('users')
    ->where('age', '>', 18)
    ->orderBy('name')
    ->limit(10)
    ->run();
```

---

### php-cron-dsl
**Repository:** [github.com/makalin/php-cron-dsl](https://github.com/makalin/php-cron-dsl)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A Domain-Specific Language (DSL) for defining cron jobs and scheduled tasks in PHP. Provides a human-readable syntax for scheduling tasks and integrates with various task schedulers.

**Key Features:**
- Human-readable cron syntax
- Type-safe scheduling
- Multiple scheduler backends
- Task dependency management
- Timezone support

**Use Cases:**
- Scheduled task management
- Cron job configuration
- Task scheduling systems
- Automated workflows
- Background job scheduling

**Example Usage:**
```php
use CronDsl\Schedule;

Schedule::every('5 minutes')
    ->run(function() {
        // Task logic
    });

Schedule::at('2:00 AM')
    ->daily()
    ->run('cleanup:database');
```

---

### php-tauri
**Repository:** [github.com/makalin/php-tauri](https://github.com/makalin/php-tauri)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
Integration between PHP and Tauri framework, enabling PHP developers to build desktop applications with native UI capabilities. Combines PHP's backend logic with Tauri's web-based frontend and native system integration.

**Key Features:**
- Tauri framework integration
- Desktop application support
- Native system APIs
- Hot reload capabilities
- Cross-platform desktop apps

**Use Cases:**
- Desktop application development
- Cross-platform GUI apps
- Native system integration
- Electron alternatives
- Desktop utilities

---

### php-supply-chain-guard
**Repository:** [github.com/makalin/php-supply-chain-guard](https://github.com/makalin/php-supply-chain-guard)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A command-line security auditing tool that scans PHP binary extensions (`.so`/`.dll` files) for potential backdoors, vulnerabilities, and suspicious code patterns. Addresses a critical gap in PHP security tooling by focusing specifically on compiled extensions.

**Key Features:**
- Binary extension analysis
- Backdoor detection
- Vulnerability scanning
- Suspicious pattern detection
- Security audit reports

**Use Cases:**
- Security auditing
- Supply chain verification
- Extension validation
- CI/CD security checks
- Compliance verification

**Example Usage:**
```bash
php-supply-chain-guard audit /usr/lib/php/extensions/
php-supply-chain-guard scan extension.so --report=json
```

---

### php-monorepo-splitter
**Repository:** [github.com/makalin/php-monorepo-splitter](https://github.com/makalin/php-monorepo-splitter)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A tool for splitting PHP monorepos into separate repositories or packages. Helps manage large codebases by automatically extracting subdirectories into independent packages while maintaining git history and dependencies.

**Key Features:**
- Monorepo splitting
- Git history preservation
- Dependency management
- Package extraction
- Automated refactoring

**Use Cases:**
- Monorepo management
- Package extraction
- Repository splitting
- Codebase organization
- Dependency isolation

---

### htmxphp
**Repository:** [github.com/makalin/htmxphp](https://github.com/makalin/htmxphp)  
**Version:** 1.0.0+  
**Release Date:** 2024  
**Status:** Active Development

**Description:**  
A lightweight PHP utility library designed to simplify the integration of HTMX into PHP projects. Provides clean, expressive functions for HTMX-specific headers, server-side logic, and response handling, facilitating the development of modern interactive web applications without heavy JavaScript frameworks.

**Key Features:**
- HTMX header helpers
- Server-side HTMX logic
- Response manipulation
- Clean API design
- Framework-agnostic

**Use Cases:**
- HTMX integration
- Modern web applications
- Server-driven UI updates
- Progressive enhancement
- Interactive web apps

**Example Usage:**
```php
use HtmxPhp\Response;

$response = Response::hxSwap('outerHTML')
    ->hxTrigger('event')
    ->withContent($html);
```

---

## Tool Compatibility Matrix

| Tool | Native (php2ir) | iOS (php-ios) | WASM (php2wasm) | Embedded (microphp) |
|------|----------------|---------------|-----------------|---------------------|
| phastron | ✅ | ✅ | ✅ | ✅ |
| php-embeddings | ✅ | ✅ | ✅ | ⚠️ Limited |
| php-querylang | ✅ | ✅ | ✅ | ⚠️ Limited |
| php-cron-dsl | ✅ | ✅ | ⚠️ Limited | ⚠️ Limited |
| php-tauri | ✅ | ❌ | ❌ | ❌ |
| php-supply-chain-guard | ✅ | ❌ | ❌ | ❌ |
| htmxphp | ⚠️ Web only | ⚠️ Web only | ⚠️ Web only | ❌ |

**Legend:**
- ✅ Fully supported
- ⚠️ Limited support or partial compatibility
- ❌ Not applicable or not supported

---

## Installation & Setup

### Individual Tool Installation

Each tool can be installed independently via Composer:

```bash
# Core compilation engines
composer require makalin/php2ir
composer require makalin/php-ios
composer require makalin/php2wasm
composer require makalin/microphp

# Supporting libraries
composer require makalin/phastron
composer require makalin/php-embeddings
composer require makalin/php-querylang
composer require makalin/php-cron-dsl

# Development tools
composer require --dev makalin/php-supply-chain-guard
composer require --dev makalin/php-monorepo-splitter

# Web utilities
composer require makalin/htmxphp
```

### Unified Installation via php-universe

The `php-universe` meta-package provides access to all tools through the `px` CLI:

```bash
composer global require makalin/php-universe
px --help
```

---

## Version History

All tools follow semantic versioning (SemVer) and are actively maintained. For the latest version information and release notes, please refer to each tool's GitHub repository.

**Last Updated:** 2025-01-XX

---

## Contributing

Contributions to any tool in the ecosystem are welcome! Please refer to each tool's individual repository for contribution guidelines, code of conduct, and issue reporting.

---

## License

All tools in the php-universe ecosystem are licensed under the MIT License unless otherwise specified in their respective repositories.

---

## Support

For questions, issues, or feature requests:
- **GitHub Issues:** Use the issue tracker in each tool's repository
- **Discussions:** Check GitHub Discussions for community support
- **Documentation:** See each tool's README.md for detailed documentation

---

*Maintained by [@makalin](https://github.com/makalin) | Supported by [Digital Vision](https://dv.com.tr)*

