<?php

/**
 * File Processor CLI Tool
 * 
 * A command-line tool that analyzes files and works as a native binary.
 * Demonstrates file I/O, error handling, and CLI argument parsing.
 */

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
        echo "Example: file_processor README.md\n";
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

