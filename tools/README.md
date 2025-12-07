# Development Tools

This directory contains helper tools and scripts for php-universe development.

## Available Tools

### project-scaffold.php

Generates a new php-universe project structure with all necessary files.

**Usage:**

```bash
php tools/project-scaffold.php my-project
php tools/project-scaffold.php my-project --target=native --target=wasm
```

**What it creates:**

- Project directory structure (`src/`, `tests/`, `dist/`)
- `composer.json` with proper configuration
- `universe.toml` with target configurations
- `src/main.php` with starter code
- `.gitignore` file
- `README.md` with usage instructions

### config-validator.php

Validates `universe.toml` configuration files.

**Usage:**

```bash
php tools/config-validator.php
php tools/config-validator.php path/to/universe.toml
```

**What it checks:**

- Configuration file exists
- Required sections present (`[project]`)
- Required fields present (`name`, `version`, `entry`)
- Target configurations are valid
- Warnings for missing optional fields

## Scripts

See the `scripts/` directory for additional helper scripts:

- `build-all.sh` - Build for all enabled targets
- `test.sh` - Run tests
- `clean.sh` - Clean build artifacts

## Contributing

To add a new tool:

1. Create a PHP script in this directory
2. Add a shebang: `#!/usr/bin/env php`
3. Make it executable: `chmod +x tools/your-tool.php`
4. Document it in this README
5. Add usage examples

