# Quick Start Guide

Get started with php-universe in minutes!

## 1. Install php-universe

```bash
composer global require makalin/php-universe
```

## 2. Create a New Project

### Option A: Use the Scaffolder Tool

```bash
php tools/project-scaffold.php my-app --target=native --target=wasm
cd my-app
composer install
```

### Option B: Use px CLI (when available)

```bash
px new my-app
cd my-app
```

### Option C: Start from an Example

```bash
cp -r examples/hello-world my-app
cd my-app
composer install
```

## 3. Write Your Code

Edit `src/main.php`:

```php
<?php

function greet(string $name): string {
    return "Hello, {$name}!";
}

if (php_sapi_name() === 'cli') {
    echo greet("World") . PHP_EOL;
}
```

## 4. Configure Targets

Edit `universe.toml` to enable your desired targets:

```toml
[project]
name = "my-app"
version = "1.0.0"
entry = "src/main.php"

[targets.native]
enabled = true
output = "dist/my-app"
```

## 5. Build

```bash
# Build for native
px build --target=native

# Or use the helper script
./scripts/build-all.sh
```

## 6. Run

```bash
./dist/my-app
```

## Using Utility Functions

Include utility functions in your project:

```php
<?php
require_once 'utils/CommonFunctions.php';
require_once 'utils/Logger.php';

use CommonFunctions;
use Logger;

$logger = new Logger();
$logger->info('Application started');

$size = CommonFunctions::formatBytes(1024 * 1024);
echo "Size: {$size}\n";
```

## Development Workflow

1. **Write code** in `src/`
2. **Test locally**: `php src/main.php`
3. **Validate config**: `php tools/config-validator.php`
4. **Build**: `px build --target=native`
5. **Test compiled**: `./dist/my-app`
6. **Clean**: `./scripts/clean.sh`

## Next Steps

- Explore [examples/](examples/) for more complex projects
- Read [TOOLS.md](TOOLS.md) for ecosystem documentation
- Check [EXAMPLES.md](EXAMPLES.md) for code examples
- See [utils/](utils/) for reusable functions

## Getting Help

- Check the [README.md](README.md) for overview
- Review [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines
- Open an issue on GitHub for questions

---

**Happy coding! 🚀**

