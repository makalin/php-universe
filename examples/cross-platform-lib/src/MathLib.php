<?php

/**
 * Cross-Platform Math Library
 * 
 * A math library that works on all platforms:
 * - Native binaries
 * - WebAssembly
 * - iOS apps
 * - Embedded devices
 */

class MathLib {
    /**
     * Calculate Fibonacci number
     */
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
    
    /**
     * Calculate factorial
     */
    public static function factorial(int $n): int {
        if ($n < 0) {
            throw new InvalidArgumentException("Factorial is not defined for negative numbers");
        }
        if ($n <= 1) return 1;
        return $n * self::factorial($n - 1);
    }
    
    /**
     * Calculate Greatest Common Divisor
     */
    public static function gcd(int $a, int $b): int {
        while ($b !== 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }
        return abs($a);
    }
    
    /**
     * Calculate Least Common Multiple
     */
    public static function lcm(int $a, int $b): int {
        if ($a == 0 || $b == 0) {
            return 0;
        }
        return abs($a * $b) / self::gcd($a, $b);
    }
    
    /**
     * Check if a number is prime
     */
    public static function isPrime(int $n): bool {
        if ($n < 2) return false;
        if ($n === 2) return true;
        if ($n % 2 === 0) return false;
        
        for ($i = 3; $i * $i <= $n; $i += 2) {
            if ($n % $i === 0) return false;
        }
        
        return true;
    }
    
    /**
     * Generate prime numbers up to a limit
     */
    public static function primes(int $limit): array {
        $primes = [];
        for ($i = 2; $i <= $limit; $i++) {
            if (self::isPrime($i)) {
                $primes[] = $i;
            }
        }
        return $primes;
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

function lcm(int $a, int $b): int {
    return MathLib::lcm($a, $b);
}

function is_prime(int $n): bool {
    return MathLib::isPrime($n) ? 1 : 0; // Return int for WASM compatibility
}

// CLI test
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $function = $argv[1];
    $args = array_slice($argv, 2);
    
    try {
        $result = match($function) {
            'fibonacci' => fibonacci((int)$args[0]),
            'factorial' => factorial((int)$args[0]),
            'gcd' => gcd((int)$args[0], (int)$args[1]),
            'lcm' => lcm((int)$args[0], (int)$args[1]),
            'is_prime' => is_prime((int)$args[0]) ? 'true' : 'false',
            default => 'Unknown function',
        };
        echo "Result: {$result}\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

