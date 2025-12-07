# Examples & Tutorials

This document provides practical examples and tutorials for using php-universe to build applications across different platforms.

---

## Table of Contents

1. [Getting Started Examples](#getting-started-examples)
2. [Native CLI Applications](#native-cli-applications)
3. [WebAssembly Applications](#webassembly-applications)
4. [iOS Applications](#ios-applications)
5. [Embedded/IoT Applications](#embeddediot-applications)
6. [Cross-Platform Libraries](#cross-platform-libraries)
7. [Advanced Use Cases](#advanced-use-cases)

---

## Getting Started Examples

### Example 1: Hello World

The simplest possible application that works on all platforms.

**`src/main.php`**

```php
<?php

function greet(string $name = "World"): string {
    return "Hello, {$name}!";
}

// Entry point
if (php_sapi_name() === 'cli') {
    $name = $argv[1] ?? "World";
    echo greet($name) . PHP_EOL;
} else {
    echo greet() . PHP_EOL;
}
```

**`universe.toml`**

```toml
[project]
name = "hello-world"
version = "1.0.0"
entry = "src/main.php"

[targets.native]
enabled = true
output = "dist/hello"

[targets.wasm]
enabled = true
expose_functions = ["greet"]
```

**Build and run:**

```bash
px build --target=native
./dist/hello "PHP Universe"
# Output: Hello, PHP Universe!
```

---

## Native CLI Applications

### Example 2: File Processor CLI Tool

A command-line tool that processes files and works as a native binary.

**`src/file_processor.php`**

```php
<?php

class FileProcessor {
    public function analyze(string $filename): array {
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: {$filename}");
        }
        
        $content = file_get_contents($filename);
        $lines = explode("\n", $content);
        
        return [
            'filename' => $filename,
            'size' => filesize($filename),
            'lines' => count($lines),
            'characters' => strlen($content),
            'words' => str_word_count($content),
            'bytes' => strlen($content),
        ];
    }
    
    public function formatOutput(array $stats): string {
        $output = "File Analysis Report\n";
        $output .= str_repeat("=", 40) . "\n";
        $output .= sprintf("Filename:    %s\n", $stats['filename']);
        $output .= sprintf("Size:        %d bytes\n", $stats['size']);
        $output .= sprintf("Lines:       %d\n", $stats['lines']);
        $output .= sprintf("Words:       %d\n", $stats['words']);
        $output .= sprintf("Characters:  %d\n", $stats['characters']);
        return $output;
    }
}

// CLI entry point
if (php_sapi_name() === 'cli') {
    if ($argc < 2) {
        echo "Usage: file_processor <filename>\n";
        exit(1);
    }
    
    $processor = new FileProcessor();
    try {
        $stats = $processor->analyze($argv[1]);
        echo $processor->formatOutput($stats);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}
```

**`universe.toml`**

```toml
[project]
name = "file-processor"
version = "1.0.0"
entry = "src/file_processor.php"

[targets.native]
enabled = true
optimization = "O3"
output = "dist/file_processor"
strip = true
```

**Usage:**

```bash
px build --target=native
./dist/file_processor README.md
```

### Example 3: JSON Data Transformer

A CLI tool that transforms JSON data with various operations.

**`src/json_transformer.php`**

```php
<?php

class JSONTransformer {
    public function filter(array $data, string $key, $value): array {
        return array_filter($data, fn($item) => $item[$key] ?? null === $value);
    }
    
    public function map(array $data, callable $callback): array {
        return array_map($callback, $data);
    }
    
    public function sort(array $data, string $key, bool $ascending = true): array {
        usort($data, function($a, $b) use ($key, $ascending) {
            $aVal = $a[$key] ?? null;
            $bVal = $b[$key] ?? null;
            $result = $aVal <=> $bVal;
            return $ascending ? $result : -$result;
        });
        return $data;
    }
}

if (php_sapi_name() === 'cli') {
    $transformer = new JSONTransformer();
    
    // Read JSON from stdin or file
    $input = $argc > 1 ? file_get_contents($argv[1]) : stream_get_contents(STDIN);
    $data = json_decode($input, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Invalid JSON: " . json_last_error_msg() . "\n";
        exit(1);
    }
    
    // Example: Sort by 'id' field
    $sorted = $transformer->sort($data, 'id');
    echo json_encode($sorted, JSON_PRETTY_PRINT) . "\n";
}
```

---

## WebAssembly Applications

### Example 4: Browser-Based Calculator

A calculator that runs entirely in the browser using WebAssembly.

**`src/calculator.php`**

```php
<?php

class Calculator {
    public function add(float $a, float $b): float {
        return $a + $b;
    }
    
    public function subtract(float $a, float $b): float {
        return $a - $b;
    }
    
    public function multiply(float $a, float $b): float {
        return $a * $b;
    }
    
    public function divide(float $a, float $b): float {
        if ($b == 0) {
            throw new DivisionByZeroError("Cannot divide by zero");
        }
        return $a / $b;
    }
    
    public function power(float $base, float $exponent): float {
        return pow($base, $exponent);
    }
}

// Export functions for WASM
function calculate(string $operation, float $a, float $b): float {
    $calc = new Calculator();
    
    return match($operation) {
        'add' => $calc->add($a, $b),
        'subtract' => $calc->subtract($a, $b),
        'multiply' => $calc->multiply($a, $b),
        'divide' => $calc->divide($a, $b),
        'power' => $calc->power($a, $b),
        default => throw new InvalidArgumentException("Unknown operation: {$operation}"),
    };
}
```

**`universe.toml`**

```toml
[project]
name = "calculator"
version = "1.0.0"
entry = "src/calculator.php"

[targets.wasm]
enabled = true
expose_functions = ["calculate"]
memory_size = "8MB"
optimization = "O3"
```

**HTML Usage:**

```html
<!DOCTYPE html>
<html>
<head>
    <title>PHP Calculator (WASM)</title>
</head>
<body>
    <h1>Calculator</h1>
    <input type="number" id="a" value="10">
    <select id="op">
        <option value="add">+</option>
        <option value="subtract">-</option>
        <option value="multiply">×</option>
        <option value="divide">÷</option>
        <option value="power">^</option>
    </select>
    <input type="number" id="b" value="5">
    <button onclick="calculate()">Calculate</button>
    <div id="result"></div>
    
    <script type="module">
        const wasmModule = await WebAssembly.instantiateStreaming(
            fetch('dist/calculator.wasm')
        );
        
        window.calculate = function() {
            const a = parseFloat(document.getElementById('a').value);
            const b = parseFloat(document.getElementById('b').value);
            const op = document.getElementById('op').value;
            
            const result = wasmModule.instance.exports.calculate(op, a, b);
            document.getElementById('result').textContent = `Result: ${result}`;
        };
    </script>
</body>
</html>
```

### Example 5: Client-Side Data Validator

Validate data in the browser before sending to server.

**`src/validator.php`**

```php
<?php

class DataValidator {
    public static function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    public static function validateURL(string $url): bool {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    
    public static function validateJSON(string $json): array {
        $decoded = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON: " . json_last_error_msg());
        }
        return $decoded;
    }
    
    public static function validatePhone(string $phone): bool {
        // Simple phone validation (customize as needed)
        return preg_match('/^\+?[\d\s\-\(\)]+$/', $phone) === 1;
    }
}

// Export functions
function validate_email(string $email): bool {
    return DataValidator::validateEmail($email);
}

function validate_url(string $url): bool {
    return DataValidator::validateURL($url);
}

function validate_json(string $json): string {
    try {
        $decoded = DataValidator::validateJSON($json);
        return json_encode(['valid' => true, 'data' => $decoded]);
    } catch (Exception $e) {
        return json_encode(['valid' => false, 'error' => $e->getMessage()]);
    }
}
```

---

## iOS Applications

### Example 6: iOS Data Processor

Process data natively in an iOS app using PHP.

**`src/data_processor.php`**

```php
<?php

class DataProcessor {
    public function processArray(array $data): array {
        return [
            'count' => count($data),
            'sum' => array_sum($data),
            'average' => count($data) > 0 ? array_sum($data) / count($data) : 0,
            'min' => count($data) > 0 ? min($data) : null,
            'max' => count($data) > 0 ? max($data) : null,
        ];
    }
    
    public function filter(array $data, callable $predicate): array {
        return array_filter($data, $predicate);
    }
    
    public function transform(array $data, callable $transform): array {
        return array_map($transform, $data);
    }
}

// Export for iOS
function process_data(string $jsonData): string {
    $processor = new DataProcessor();
    $data = json_decode($jsonData, true);
    $result = $processor->processArray($data);
    return json_encode($result);
}
```

**Swift Integration:**

```swift
import PhpEngine

let engine = PhpEngine()
let data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
let jsonData = try JSONEncoder().encode(data)

if let result = try? engine.call("process_data", with: String(data: jsonData, encoding: .utf8)!) {
    print("Processed: \(result)")
}
```

---

## Embedded/IoT Applications

### Example 7: Sensor Data Logger

Process sensor readings on an ESP32 device.

**`src/sensor_logger.php`**

```php
<?php

class SensorLogger {
    private array $readings = [];
    private const MAX_READINGS = 100;
    
    public function addReading(float $value, int $timestamp): void {
        $this->readings[] = [
            'value' => $value,
            'timestamp' => $timestamp,
        ];
        
        // Keep only last MAX_READINGS
        if (count($this->readings) > self::MAX_READINGS) {
            array_shift($this->readings);
        }
    }
    
    public function getStats(): array {
        if (empty($this->readings)) {
            return ['error' => 'No readings available'];
        }
        
        $values = array_column($this->readings, 'value');
        
        return [
            'count' => count($values),
            'average' => array_sum($values) / count($values),
            'min' => min($values),
            'max' => max($values),
            'latest' => end($this->readings),
        ];
    }
    
    public function clear(): void {
        $this->readings = [];
    }
}

// Entry point for embedded device
$logger = new SensorLogger();

// Simulate sensor readings (in real device, these come from hardware)
for ($i = 0; $i < 10; $i++) {
    $logger->addReading(rand(20, 30) + (rand(0, 100) / 100), time() + $i);
}

$stats = $logger->getStats();
echo json_encode($stats) . "\n";
```

**`universe.toml`**

```toml
[project]
name = "sensor-logger"
version = "1.0.0"
entry = "src/sensor_logger.php"

[targets.embedded]
enabled = true
platform = "esp32"
flash_size = "4MB"
```

---

## Cross-Platform Libraries

### Example 8: Universal Math Library

A math library that works on all platforms.

**`src/math_lib.php`**

```php
<?php

class MathLib {
    public static function fibonacci(int $n): int {
        if ($n <= 1) return $n;
        if ($n === 2) return 1;
        
        $a = 1;
        $b = 1;
        
        for ($i = 3; $i <= $n; $i++) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
        
        return $b;
    }
    
    public static function factorial(int $n): int {
        if ($n <= 1) return 1;
        return $n * self::factorial($n - 1);
    }
    
    public static function gcd(int $a, int $b): int {
        while ($b !== 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }
        return abs($a);
    }
    
    public static function lcm(int $a, int $b): int {
        return abs($a * $b) / self::gcd($a, $b);
    }
    
    public static function isPrime(int $n): bool {
        if ($n < 2) return false;
        if ($n === 2) return true;
        if ($n % 2 === 0) return false;
        
        for ($i = 3; $i * $i <= $n; $i += 2) {
            if ($n % $i === 0) return false;
        }
        
        return true;
    }
}

// Export functions for WASM/iOS
function fibonacci(int $n): int {
    return MathLib::fibonacci($n);
}

function factorial(int $n): int {
    return MathLib::factorial($n);
}

function gcd(int $a, int $b): int {
    return MathLib::gcd($a, $b);
}
```

---

## Advanced Use Cases

### Example 9: Using php-embeddings for Semantic Search

**`src/semantic_search.php`**

```php
<?php

use PhpEmbeddings\VectorDB;

class SemanticSearch {
    private array $documents = [];
    
    public function index(string $id, string $text): void {
        $vector = VectorDB::embed($text);
        $this->documents[$id] = [
            'text' => $text,
            'vector' => $vector,
        ];
    }
    
    public function search(string $query, float $threshold = 0.7): array {
        $queryVector = VectorDB::embed($query);
        $results = [];
        
        foreach ($this->documents as $id => $doc) {
            $similarity = VectorDB::cosineSimilarity($queryVector, $doc['vector']);
            if ($similarity >= $threshold) {
                $results[] = [
                    'id' => $id,
                    'text' => $doc['text'],
                    'similarity' => $similarity,
                ];
            }
        }
        
        // Sort by similarity
        usort($results, fn($a, $b) => $b['similarity'] <=> $a['similarity']);
        
        return $results;
    }
}
```

### Example 10: Using php-querylang for Data Querying

**`src/data_query.php`**

```php
<?php

use QueryLang\Query;

class DataQuery {
    private array $data = [];
    
    public function loadData(array $data): void {
        $this->data = $data;
    }
    
    public function findUsers(int $minAge, string $city): array {
        return Query::select('*')
            ->from($this->data)
            ->where('age', '>=', $minAge)
            ->where('city', '=', $city)
            ->orderBy('name')
            ->run();
    }
    
    public function aggregate(string $field): array {
        return Query::select($field)
            ->from($this->data)
            ->groupBy($field)
            ->aggregate('count', '*')
            ->run();
    }
}
```

---

## Tips & Best Practices

### 1. Platform-Specific Code

Use feature detection instead of platform checks:

```php
<?php

function processData($data) {
    // Check for available features, not platform
    if (function_exists('file_get_contents')) {
        // Use file operations
    } else {
        // Use alternative approach
    }
}
```

### 2. Memory Management

For embedded targets, be mindful of memory:

```php
<?php

class MemoryEfficient {
    public function processStream(iterable $data): iterable {
        foreach ($data as $item) {
            yield $this->process($item);
            // Memory is freed after each iteration
        }
    }
}
```

### 3. Error Handling

Always handle errors gracefully:

```php
<?php

function safeOperation($input) {
    try {
        return riskyOperation($input);
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        return null; // Or appropriate default
    }
}
```

### 4. Testing

Test your code before compiling:

```php
<?php

// test.php
require_once 'src/main.php';

assert(greet("Test") === "Hello, Test!");
assert(calculate(2, 3) === 5);
echo "All tests passed!\n";
```

---

## Next Steps

- Explore more examples in the [php-universe repository](https://github.com/makalin/php-universe)
- Read the [TOOLS.md](TOOLS.md) documentation
- Check out individual tool repositories for platform-specific examples
- Join the community discussions on GitHub

---

*Have an example to share? Submit a PR with your example!*

