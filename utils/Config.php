<?php

/**
 * Configuration Manager
 * 
 * Simple configuration management that works across all platforms.
 * Supports environment variables, defaults, and type casting.
 */

class Config {
    private array $config = [];
    private array $defaults = [];
    
    public function __construct(array $config = [], array $defaults = []) {
        $this->config = $config;
        $this->defaults = $defaults;
    }
    
    public function get(string $key, mixed $default = null): mixed {
        $value = $this->arrayGet($this->config, $key) 
            ?? $this->arrayGet($this->defaults, $key) 
            ?? $default;
        
        // Check environment variable
        $envKey = strtoupper(str_replace('.', '_', $key));
        if (function_exists('getenv') && ($envValue = getenv($envKey)) !== false) {
            return $this->castValue($envValue);
        }
        
        return $value;
    }
    
    public function set(string $key, mixed $value): void {
        $this->arraySet($this->config, $key, $value);
    }
    
    public function has(string $key): bool {
        return $this->arrayHas($this->config, $key) || $this->arrayHas($this->defaults, $key);
    }
    
    public function all(): array {
        return array_merge($this->defaults, $this->config);
    }
    
    public function merge(array $config): void {
        $this->config = array_merge_recursive($this->config, $config);
    }
    
    private function arrayGet(array $array, string $key): mixed {
        $keys = explode('.', $key);
        $value = $array;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return null;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    private function arraySet(array &$array, string $key, mixed $value): void {
        $keys = explode('.', $key);
        $current = &$array;
        
        foreach ($keys as $k) {
            if (!isset($current[$k]) || !is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }
        
        $current = $value;
    }
    
    private function arrayHas(array $array, string $key): bool {
        $keys = explode('.', $key);
        $value = $array;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return false;
            }
            $value = $value[$k];
        }
        
        return true;
    }
    
    private function castValue(mixed $value): mixed {
        if (is_bool($value) || is_int($value) || is_float($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            // Try to detect boolean
            if (in_array(strtolower($value), ['true', 'false'])) {
                return strtolower($value) === 'true';
            }
            
            // Try to detect number
            if (is_numeric($value)) {
                return str_contains($value, '.') ? (float)$value : (int)$value;
            }
            
            // Try JSON decode
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }
        
        return $value;
    }
}

