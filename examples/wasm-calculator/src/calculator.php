<?php

/**
 * WebAssembly Calculator
 * 
 * A calculator that runs entirely in the browser using WebAssembly.
 * Demonstrates function exports, error handling, and WASM integration.
 */

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
    
    public function sqrt(float $value): float {
        if ($value < 0) {
            throw new InvalidArgumentException("Cannot calculate square root of negative number");
        }
        return sqrt($value);
    }
}

// Export functions for WASM
function calculate(string $operation, float $a, float $b = 0.0): float {
    $calc = new Calculator();
    
    return match($operation) {
        'add' => $calc->add($a, $b),
        'subtract' => $calc->subtract($a, $b),
        'multiply' => $calc->multiply($a, $b),
        'divide' => $calc->divide($a, $b),
        'power' => $calc->power($a, $b),
        'sqrt' => $calc->sqrt($a),
        default => throw new InvalidArgumentException("Unknown operation: {$operation}"),
    };
}

// CLI fallback for testing
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    try {
        $op = $argv[1];
        $a = (float)($argv[2] ?? 0);
        $b = (float)($argv[3] ?? 0);
        $result = calculate($op, $a, $b);
        echo "Result: {$result}\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

