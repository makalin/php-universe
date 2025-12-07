<?php

/**
 * Hello World Example
 * 
 * The simplest possible php-universe application.
 * This demonstrates basic PHP code that can be compiled
 * to native binaries, WebAssembly, iOS, or embedded devices.
 */

function greet(string $name = "World"): string {
    return "Hello, {$name}!";
}

function calculate(int $a, int $b): int {
    return $a + $b;
}

// Entry point
if (php_sapi_name() === 'cli') {
    $name = $argv[1] ?? "World";
    echo greet($name) . PHP_EOL;
    echo "2 + 3 = " . calculate(2, 3) . PHP_EOL;
} else {
    echo greet() . PHP_EOL;
}

