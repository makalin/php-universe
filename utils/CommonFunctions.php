<?php

/**
 * Common Utility Functions
 * 
 * A collection of commonly used utility functions that work across all platforms.
 * These functions are designed to be platform-agnostic and compile to all targets.
 */

class CommonFunctions {
    /**
     * Format bytes to human-readable format
     */
    public static function formatBytes(int $bytes, int $precision = 2): string {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    
    /**
     * Generate a random string
     */
    public static function randomString(int $length = 10, string $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'): string {
        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, $max)];
        }
        return $result;
    }
    
    /**
     * Check if string is valid JSON
     */
    public static function isValidJson(string $string): bool {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
    
    /**
     * Safe JSON decode with error handling
     */
    public static function safeJsonDecode(string $json, bool $assoc = true): ?array {
        $decoded = json_decode($json, $assoc);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }
    
    /**
     * Array deep merge
     */
    public static function arrayMergeDeep(array ...$arrays): array {
        $result = [];
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                    $result[$key] = self::arrayMergeDeep($result[$key], $value);
                } else {
                    $result[$key] = $value;
                }
            }
        }
        return $result;
    }
    
    /**
     * Flatten nested array
     */
    public static function arrayFlatten(array $array, string $prefix = ''): array {
        $result = [];
        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;
            if (is_array($value)) {
                $result = array_merge($result, self::arrayFlatten($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }
    
    /**
     * Get array value with default
     */
    public static function arrayGet(array $array, string $key, mixed $default = null): mixed {
        return $array[$key] ?? $default;
    }
    
    /**
     * Set array value using dot notation
     */
    public static function arraySet(array &$array, string $key, mixed $value): void {
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
    
    /**
     * Truncate string with ellipsis
     */
    public static function truncate(string $string, int $length, string $suffix = '...'): string {
        if (strlen($string) <= $length) {
            return $string;
        }
        return substr($string, 0, $length - strlen($suffix)) . $suffix;
    }
    
    /**
     * Slugify string
     */
    public static function slugify(string $string): string {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }
    
    /**
     * Check if value is between two numbers
     */
    public static function between(mixed $value, float $min, float $max): bool {
        return $value >= $min && $value <= $max;
    }
    
    /**
     * Clamp value between min and max
     */
    public static function clamp(mixed $value, float $min, float $max): float {
        return max($min, min($max, (float)$value));
    }
    
    /**
     * Calculate percentage
     */
    public static function percentage(float $part, float $total): float {
        if ($total == 0) {
            return 0;
        }
        return ($part / $total) * 100;
    }
    
    /**
     * Format number with thousands separator
     */
    public static function formatNumber(float $number, int $decimals = 0): string {
        return number_format($number, $decimals, '.', ',');
    }
    
    /**
     * Check if string starts with substring
     */
    public static function startsWith(string $haystack, string $needle): bool {
        return str_starts_with($haystack, $needle);
    }
    
    /**
     * Check if string ends with substring
     */
    public static function endsWith(string $haystack, string $needle): bool {
        return str_ends_with($haystack, $needle);
    }
    
    /**
     * Remove whitespace from string
     */
    public static function removeWhitespace(string $string): string {
        return preg_replace('/\s+/', '', $string);
    }
    
    /**
     * Extract numbers from string
     */
    public static function extractNumbers(string $string): array {
        preg_match_all('/\d+/', $string, $matches);
        return array_map('intval', $matches[0]);
    }
    
    /**
     * Generate UUID v4
     */
    public static function uuid(): string {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Variant 10
        
        return sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            bin2hex(substr($data, 0, 4)),
            bin2hex(substr($data, 4, 2)),
            bin2hex(substr($data, 6, 2)),
            bin2hex(substr($data, 8, 2)),
            bin2hex(substr($data, 10, 6))
        );
    }
}

