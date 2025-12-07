# php-universe / px

[](https://www.google.com/search?q=LICENSE)
[](https://php.net)
[](https://www.google.com/search?q=%23)

**The Universal PHP Toolchain.**
*Write Once. Compile Everywhere. No, really.*

**`px`** is a CLI build system that unifies the PHP systems ecosystem. It orchestrates [php2ir](https://github.com/makalin/php2ir), [php-ios](https://github.com/makalin/php-ios), [php2wasm](https://github.com/makalin/php2wasm), and [microphp](https://github.com/makalin/microphp) to compile a single PHP codebase into native binaries, mobile apps, web assembly modules, or embedded firmware.

-----

## 🚀 Why?

PHP is the world's most popular web language, but it has been trapped in the server-side request/response cycle. The tools to break it out exist, but they are fragmented.

**`px`** changes the paradigm. It allows you to build:

  * **Systems Tools** (CLI apps, Daemons) → via **LLVM/Native**
  * **Mobile Logic** (Offline, On-device) → via **iOS Static Libs**
  * **Edge/Browser** (Sandboxed Agents) → via **WASM**
  * **IoT/Hardware** (Microcontrollers) → via **Embedded Runtime**

...all using the same `src/` directory and familiar PHP syntax.

-----

## 📦 Architecture

`px` acts as a meta-compiler and dependency manager. It reads a `universe.toml` configuration and delegates compilation to the specialized engines developed by [@makalin](https://github.com/makalin).

```mermaid
graph TD
    SRC[PHP Source Code] --> PX[px CLI]
    PX -->|Target: Native| P2IR[php2ir (LLVM)]
    PX -->|Target: iOS| PIOS[php-ios (Static Lib)]
    PX -->|Target: Web| PWASM[php2wasm (Emscripten)]
    PX -->|Target: IoT| UPHP[microphp (Firmware)]
    
    P2IR --> BIN[Linux/Mac/Win Binary]
    PIOS --> IPA[iOS Framework]
    PWASM --> WASM[Wasm Module]
    UPHP --> ESP[ESP32/Pico Bin]
```

-----

## 🛠 Installation

```bash
composer global require makalin/php-universe
```

*Requirements: PHP 8.2+, Clang/LLVM, and target-specific SDKs (e.g., Xcode for iOS).*

-----

## ⚡ Quick Start

### 1\. Initialize a Universal Project

```bash
px new my-super-app
cd my-super-app
```

This creates a standard structure:

```text
my-super-app/
├── src/
│   └── main.php       # Your entry point
├── universe.toml      # The build configuration
└── vendor/            # Dependencies
```

### 2\. Configure Targets (`universe.toml`)

Tell `px` where you want your code to run.

```toml
[project]
name = "SuperApp"
version = "1.0.0"
entry = "src/main.php"

[targets.native]
enabled = true
optimization = "O3"
output = "dist/superapp"

[targets.ios]
enabled = true
bundle_id = "com.dv.superapp"

[targets.wasm]
enabled = true
expose_functions = ["calculate_hash", "process_data"]

[targets.embedded]
enabled = false
platform = "esp32"
```

### 3\. Build

```bash
# Build for your current machine (Native)
px build --target=native

# Build for the web
px build --target=wasm

# Build all configured targets
px build --all
```

-----

## 🧠 The Engines

`px` relies on a suite of high-performance PHP innovations:

| Engine | Purpose | Usage |
| :--- | :--- | :--- |
| **[php2ir](https://github.com/makalin/php2ir)** | **Native Compilation.** Compiles PHP 8.x directly to LLVM IR, skipping C entirely. Produces standalone binaries with no VM overhead. | `px build -t native` |
| **[php-ios](https://github.com/makalin/php-ios)** | **Mobile.** Embeds a static PHP runtime into iOS apps. Fully App Store compliant. | `px build -t ios` |
| **[php2wasm](https://github.com/makalin/php2wasm)** | **WebAssembly.** Runs PHP in the browser or Cloudflare Workers. | `px build -t wasm` |
| **[microphp](https://github.com/makalin/microphp)** | **Embedded/IoT.** A 2MB runtime for ESP32 and RP2040. | `px build -t embedded` |
| **[phastron](https://github.com/makalin/phastron)** | **Standard Lib.** High-performance AST and data structures optimized for compiled PHP. | *Auto-included* |

-----

## 💡 Example: An "Edge AI" Agent

Imagine an AI agent that filters data locally. You write it once in PHP.

**`src/Agent.php`**

```php
<?php
use PhpEmbeddings\VectorDB; // via makalin/php-embeddings
use QueryLang\Query;        // via makalin/php-querylang

function process_input(string $input): string {
    // 1. Convert input to vector
    $vec = VectorDB::embed($input);
    
    // 2. Query local memory (no API calls!)
    $memory = Query::select('*')
        ->from('long_term_memory')
        ->where('similarity', '>', 0.85)
        ->run();
        
    return json_encode($memory);
}
```

  * **On Server:** Compiles to a binary microservice (`php2ir`).
  * **On Browser:** Runs client-side to save bandwidth (`php2wasm`).
  * **On Mobile:** Runs inside the user's secure enclave (`php-ios`).

-----

## 🗺 Roadmap

  * [ ] **Package Manager**: A `cargo`-like dependency resolver that ensures packages are compatible with specific targets (e.g., flagging dependencies that use `curl` when compiling for `microphp`).
  * [ ] **Hot Reload**: `px watch` for instant feedback during native development (powered by [php-tauri](https://github.com/makalin/php-tauri)).
  * [ ] **FFI Scaffolding**: Auto-generate PHP bindings for C libraries during the native build process.

-----

## 🤝 Contributing

This is a meta-project. Contributions are best directed to the specific engines based on your area of expertise.

-----

## 📜 License

MIT © 2025 [Mehmet T. AKALIN](https://github.com/makalin).

Supported by [Digital Vision](https://dv.com.tr).
