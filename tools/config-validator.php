#!/usr/bin/env php
<?php

/**
 * Configuration Validator
 * 
 * Validates universe.toml configuration files.
 * Usage: php tools/config-validator.php [path/to/universe.toml]
 */

class ConfigValidator {
    private array $errors = [];
    private array $warnings = [];
    
    public function validate(string $configPath): bool {
        if (!file_exists($configPath)) {
            $this->errors[] = "Configuration file not found: {$configPath}";
            return false;
        }
        
        $content = file_get_contents($configPath);
        $this->validateSyntax($content);
        $this->validateStructure($content);
        $this->validateTargets($content);
        
        return empty($this->errors);
    }
    
    private function validateSyntax(string $content): void {
        // Basic TOML syntax checks
        if (!str_contains($content, '[project]')) {
            $this->errors[] = "Missing [project] section";
        }
    }
    
    private function validateStructure(string $content): void {
        $requiredFields = ['name', 'version', 'entry'];
        
        foreach ($requiredFields as $field) {
            if (!preg_match("/^\s*{$field}\s*=/m", $content)) {
                $this->errors[] = "Missing required field: {$field}";
            }
        }
    }
    
    private function validateTargets(string $content): void {
        $targets = ['native', 'wasm', 'ios', 'embedded'];
        
        foreach ($targets as $target) {
            if (preg_match("/\[targets\.{$target}\]/", $content)) {
                if (!preg_match("/^\s*enabled\s*=\s*(true|false)/m", $content)) {
                    $this->warnings[] = "Target '{$target}' is missing 'enabled' field";
                }
            }
        }
    }
    
    public function getErrors(): array {
        return $this->errors;
    }
    
    public function getWarnings(): array {
        return $this->warnings;
    }
    
    public function printReport(): void {
        if (empty($this->errors) && empty($this->warnings)) {
            echo "✅ Configuration is valid!\n";
            return;
        }
        
        if (!empty($this->errors)) {
            echo "❌ Errors:\n";
            foreach ($this->errors as $error) {
                echo "  - {$error}\n";
            }
        }
        
        if (!empty($this->warnings)) {
            echo "⚠️  Warnings:\n";
            foreach ($this->warnings as $warning) {
                echo "  - {$warning}\n";
            }
        }
    }
}

if (php_sapi_name() === 'cli') {
    $configPath = $argv[1] ?? 'universe.toml';
    
    $validator = new ConfigValidator();
    $isValid = $validator->validate($configPath);
    $validator->printReport();
    
    exit($isValid ? 0 : 1);
}

