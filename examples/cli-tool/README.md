# CLI Tool Example

A command-line file processor that demonstrates:
- File I/O operations
- Error handling
- CLI argument parsing
- Formatted output

## Usage

```bash
cd examples/cli-tool
composer install
px build --target=native
./dist/file-processor README.md
```

## Example Output

```
File Analysis Report
========================================
Filename:    README.md
Size:        1234 bytes
Lines:       45
Words:       234
Characters:  1234
```

## Features

- Analyzes file statistics
- Handles missing files gracefully
- Provides formatted, readable output
- Compiles to a standalone native binary

