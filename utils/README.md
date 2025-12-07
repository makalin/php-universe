# Utility Functions

This directory contains reusable utility functions and classes that work across all php-universe targets.

## Available Utilities

### CommonFunctions

A collection of commonly used utility functions:

- `formatBytes()` - Format bytes to human-readable format
- `randomString()` - Generate random strings
- `isValidJson()` - Validate JSON strings
- `safeJsonDecode()` - Safe JSON decoding with error handling
- `arrayMergeDeep()` - Deep merge arrays
- `arrayFlatten()` - Flatten nested arrays
- `truncate()` - Truncate strings with ellipsis
- `slugify()` - Convert strings to URL-friendly slugs
- `between()` - Check if value is between two numbers
- `clamp()` - Clamp values between min and max
- `percentage()` - Calculate percentages
- `formatNumber()` - Format numbers with thousands separator
- `uuid()` - Generate UUID v4

**Usage:**

```php
use CommonFunctions;

$size = CommonFunctions::formatBytes(1024 * 1024); // "1 MB"
$slug = CommonFunctions::slugify("Hello World!"); // "hello-world"
$id = CommonFunctions::uuid(); // "550e8400-e29b-41d4-a716-446655440000"
```

### Logger

A lightweight logging utility:

- `debug()` - Log debug messages
- `info()` - Log info messages
- `warning()` - Log warnings
- `error()` - Log errors
- `getLogs()` - Get all logs
- `export()` - Export logs in various formats

**Usage:**

```php
use Logger;

$logger = new Logger('INFO', true);
$logger->info('Application started', ['version' => '1.0.0']);
$logger->error('Something went wrong', ['code' => 500]);

// Get logs
$allLogs = $logger->getLogs();
$errors = $logger->getLogsByLevel('ERROR');
```

### Config

Configuration management with environment variable support:

- `get()` - Get configuration value
- `set()` - Set configuration value
- `has()` - Check if key exists
- `all()` - Get all configuration
- `merge()` - Merge configuration

**Usage:**

```php
use Config;

$config = new Config([
    'app' => [
        'name' => 'MyApp',
        'version' => '1.0.0',
    ],
], [
    'app.debug' => false,
]);

$name = $config->get('app.name'); // "MyApp"
$debug = $config->get('app.debug'); // false (from defaults)
```

## Platform Compatibility

All utilities in this directory are designed to work across all php-universe targets:

- ✅ Native binaries
- ✅ WebAssembly
- ✅ iOS applications
- ✅ Embedded devices

## Including in Your Project

### Option 1: Copy files

Copy the utility files you need into your project's `src/` directory.

### Option 2: Composer autoload

Add to your `composer.json`:

```json
{
    "autoload": {
        "files": [
            "utils/CommonFunctions.php",
            "utils/Logger.php",
            "utils/Config.php"
        ]
    }
}
```

### Option 3: Git submodule

Add as a git submodule or include via Composer if published as a package.

## Contributing

Feel free to add more utility functions! Keep in mind:

- Functions should be platform-agnostic
- Avoid file system operations unless necessary
- Use pure functions when possible
- Document all functions with PHPDoc
- Include usage examples

