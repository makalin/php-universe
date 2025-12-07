<?php

/**
 * Simple Logger
 * 
 * A lightweight logging utility that works across all platforms.
 * Platform-agnostic logging without file system dependencies.
 */

class Logger {
    private const LEVELS = [
        'DEBUG' => 0,
        'INFO' => 1,
        'WARNING' => 2,
        'ERROR' => 3,
    ];
    
    private int $minLevel;
    private array $logs = [];
    private bool $outputToStdout;
    
    public function __construct(string $minLevel = 'INFO', bool $outputToStdout = true) {
        $this->minLevel = self::LEVELS[$minLevel] ?? self::LEVELS['INFO'];
        $this->outputToStdout = $outputToStdout;
    }
    
    public function debug(string $message, array $context = []): void {
        $this->log('DEBUG', $message, $context);
    }
    
    public function info(string $message, array $context = []): void {
        $this->log('INFO', $message, $context);
    }
    
    public function warning(string $message, array $context = []): void {
        $this->log('WARNING', $message, $context);
    }
    
    public function error(string $message, array $context = []): void {
        $this->log('ERROR', $message, $context);
    }
    
    private function log(string $level, string $message, array $context = []): void {
        if (self::LEVELS[$level] < $this->minLevel) {
            return;
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = $this->formatMessage($level, $message, $context, $timestamp);
        
        $this->logs[] = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'timestamp' => $timestamp,
            'formatted' => $formattedMessage,
        ];
        
        if ($this->outputToStdout) {
            echo $formattedMessage . PHP_EOL;
        }
    }
    
    private function formatMessage(string $level, string $message, array $context, string $timestamp): string {
        $formatted = "[{$timestamp}] [{$level}] {$message}";
        
        if (!empty($context)) {
            $formatted .= ' ' . json_encode($context);
        }
        
        return $formatted;
    }
    
    public function getLogs(): array {
        return $this->logs;
    }
    
    public function getLogsByLevel(string $level): array {
        return array_filter($this->logs, fn($log) => $log['level'] === $level);
    }
    
    public function clear(): void {
        $this->logs = [];
    }
    
    public function export(string $format = 'json'): string {
        return match($format) {
            'json' => json_encode($this->logs, JSON_PRETTY_PRINT),
            'text' => implode("\n", array_column($this->logs, 'formatted')),
            default => json_encode($this->logs),
        };
    }
}

