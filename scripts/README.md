# Helper Scripts

This directory contains shell scripts to help with common development tasks.

## Available Scripts

### build-all.sh

Builds the project for all enabled targets in `universe.toml`.

**Usage:**

```bash
./scripts/build-all.sh
```

**What it does:**

- Checks for `universe.toml`
- Verifies `px` command is available
- Builds for each enabled target (native, wasm, ios, embedded)
- Skips disabled targets
- Reports build status

### test.sh

Runs tests for the project.

**Usage:**

```bash
./scripts/test.sh
```

**What it does:**

- Checks for `tests/` directory
- Runs PHPUnit if available
- Falls back to syntax checking if PHPUnit not found
- Creates example test file if tests directory doesn't exist

### clean.sh

Removes build artifacts and temporary files.

**Usage:**

```bash
./scripts/clean.sh
```

**What it removes:**

- `dist/` directory
- `*.wasm` files
- `*.o` object files
- `*.a` archive files
- `.phpunit.result.cache` files

## Making Scripts Executable

If scripts aren't executable:

```bash
chmod +x scripts/*.sh
```

## Platform Compatibility

These scripts are designed for Unix-like systems (Linux, macOS). For Windows:

- Use Git Bash or WSL
- Or adapt scripts to PowerShell/batch files
- Or use the PHP tools directly

## Contributing

To add a new script:

1. Create a shell script in this directory
2. Add shebang: `#!/bin/bash`
3. Use `set -e` for error handling
4. Add clear echo messages
5. Document it in this README

