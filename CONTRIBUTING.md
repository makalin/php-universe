# Contributing to php-universe

Thank you for your interest in contributing to php-universe! This document provides guidelines and instructions for contributing to the project and its ecosystem.

---

## Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [How to Contribute](#how-to-contribute)
3. [Development Setup](#development-setup)
4. [Project Structure](#project-structure)
5. [Submitting Changes](#submitting-changes)
6. [Coding Standards](#coding-standards)
7. [Testing](#testing)
8. [Documentation](#documentation)

---

## Code of Conduct

This project adheres to a code of conduct that all contributors are expected to follow:

- Be respectful and inclusive
- Welcome newcomers and help them learn
- Focus on constructive feedback
- Respect different viewpoints and experiences

---

## How to Contribute

There are many ways to contribute to php-universe:

### Reporting Bugs

If you find a bug, please open an issue with:

- **Clear title and description**
- **Steps to reproduce** the issue
- **Expected behavior** vs **actual behavior**
- **Environment information** (OS, PHP version, tool versions)
- **Minimal code example** that reproduces the issue

### Suggesting Features

Feature suggestions are welcome! Open an issue with:

- **Clear description** of the feature
- **Use case** explaining why it's needed
- **Proposed implementation** (if you have ideas)
- **Alternatives considered** (if any)

### Submitting Code

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Add tests if applicable
5. Update documentation
6. Commit your changes (`git commit -m 'Add amazing feature'`)
7. Push to your branch (`git push origin feature/amazing-feature`)
8. Open a Pull Request

### Improving Documentation

Documentation improvements are always welcome! You can:

- Fix typos and grammar
- Clarify unclear explanations
- Add missing examples
- Improve code comments
- Translate documentation

---

## Development Setup

### Prerequisites

- PHP 8.2 or higher
- Composer
- Git
- Target-specific SDKs (if working on specific engines)

### Installation

```bash
# Clone the repository
git clone https://github.com/makalin/php-universe.git
cd php-universe

# Install dependencies
composer install

# Verify installation
./vendor/bin/px --version
```

### Development Workflow

1. **Create a branch** for your changes
2. **Make changes** following coding standards
3. **Test your changes** thoroughly
4. **Update documentation** as needed
5. **Commit** with clear messages
6. **Push** and create a PR

---

## Project Structure

php-universe is a meta-project that orchestrates multiple tools:

```
php-universe/
├── README.md           # Main project documentation
├── TOOLS.md            # Tools ecosystem documentation
├── EXAMPLES.md         # Code examples and tutorials
├── CONTRIBUTING.md     # This file
├── LICENSE             # MIT License
└── src/                # Source code (if applicable)
```

**Note:** Most development happens in individual tool repositories:
- [php2ir](https://github.com/makalin/php2ir) - Native compilation
- [php-ios](https://github.com/makalin/php-ios) - iOS support
- [php2wasm](https://github.com/makalin/php2wasm) - WebAssembly
- [microphp](https://github.com/makalin/microphp) - Embedded/IoT
- And others...

---

## Submitting Changes

### Pull Request Process

1. **Update your branch** with the latest changes from main
2. **Ensure all tests pass**
3. **Update documentation** if needed
4. **Write a clear PR description**:
   - What changes were made
   - Why they were made
   - How to test them
   - Any breaking changes

### Commit Messages

Follow conventional commit format:

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(cli): add --watch flag for hot reload
fix(wasm): resolve memory leak in string handling
docs(readme): add installation instructions for macOS
```

---

## Coding Standards

### PHP Code Style

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
- Use type hints wherever possible
- Add docblocks for public methods
- Keep functions focused and small
- Use meaningful variable and function names

### Example

```php
<?php

declare(strict_types=1);

namespace PhpUniverse\Example;

/**
 * Processes data for various targets.
 */
class DataProcessor
{
    /**
     * Process an array of data.
     *
     * @param array<string, mixed> $data The data to process
     * @return array<string, mixed> Processed data
     * @throws InvalidArgumentException If data is invalid
     */
    public function process(array $data): array
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Data cannot be empty');
        }
        
        return $this->transform($data);
    }
    
    private function transform(array $data): array
    {
        // Implementation
        return $data;
    }
}
```

### Configuration Files

- Use consistent formatting
- Add comments for clarity
- Follow existing patterns

---

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run specific test suite
vendor/bin/phpunit tests/

# Run with coverage
vendor/bin/phpunit --coverage-html coverage/
```

### Writing Tests

- Write tests for new features
- Ensure tests are deterministic
- Use descriptive test names
- Test edge cases and error conditions

**Example:**

```php
<?php

use PHPUnit\Framework\TestCase;

class DataProcessorTest extends TestCase
{
    public function testProcessValidData(): void
    {
        $processor = new DataProcessor();
        $result = $processor->process(['key' => 'value']);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('key', $result);
    }
    
    public function testProcessEmptyDataThrowsException(): void
    {
        $processor = new DataProcessor();
        
        $this->expectException(InvalidArgumentException::class);
        $processor->process([]);
    }
}
```

### Testing Across Targets

When possible, test your code on multiple targets:

```bash
# Test native compilation
px build --target=native && ./dist/app

# Test WASM compilation
px build --target=wasm

# Test iOS (requires macOS/Xcode)
px build --target=ios
```

---

## Documentation

### Code Documentation

- Add docblocks for all public methods
- Explain complex logic with comments
- Keep comments up-to-date with code changes

### User Documentation

When adding features, update:

- **README.md** - If it affects main functionality
- **TOOLS.md** - If it's a new tool or major feature
- **EXAMPLES.md** - Add examples for new features
- **API docs** - If applicable

### Documentation Style

- Use clear, concise language
- Provide code examples
- Explain the "why" not just the "what"
- Keep examples up-to-date and runnable

---

## Where to Contribute

### Core Tools (High Priority)

These are the main compilation engines:

- **[php2ir](https://github.com/makalin/php2ir)** - Native compilation improvements
- **[php-ios](https://github.com/makalin/php-ios)** - iOS integration features
- **[php2wasm](https://github.com/makalin/php2wasm)** - WebAssembly support
- **[microphp](https://github.com/makalin/microphp)** - Embedded runtime

### Supporting Libraries

- **[phastron](https://github.com/makalin/phastron)** - Standard library
- **[php-embeddings](https://github.com/makalin/php-embeddings)** - Vector operations
- **[php-querylang](https://github.com/makalin/php-querylang)** - Query builder
- **[php-cron-dsl](https://github.com/makalin/php-cron-dsl)** - Scheduling

### Meta-Project (This Repository)

- CLI improvements (`px` command)
- Documentation improvements
- Example projects
- Integration testing

---

## Getting Help

- **GitHub Issues** - For bugs and feature requests
- **GitHub Discussions** - For questions and discussions
- **Documentation** - Check [TOOLS.md](TOOLS.md) and [EXAMPLES.md](EXAMPLES.md)

---

## Recognition

Contributors will be:

- Listed in the project's CONTRIBUTORS file (if applicable)
- Credited in release notes for significant contributions
- Appreciated by the community! 🙏

---

## License

By contributing, you agree that your contributions will be licensed under the MIT License, the same license that covers the project.

---

**Thank you for contributing to php-universe!** 🚀

*Questions? Open an issue or start a discussion on GitHub.*

