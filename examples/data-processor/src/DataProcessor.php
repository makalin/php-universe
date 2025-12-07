<?php

/**
 * Data Processor Example
 * 
 * Demonstrates data processing utilities that work across all platforms.
 * Uses utility functions from utils/ directory.
 */

require_once __DIR__ . '/../../utils/CommonFunctions.php';
require_once __DIR__ . '/../../utils/Logger.php';

class DataProcessor {
    private Logger $logger;
    
    public function __construct() {
        $this->logger = new Logger('INFO', php_sapi_name() === 'cli');
    }
    
    public function processArray(array $data, callable $processor): array {
        $this->logger->info('Processing array', ['count' => count($data)]);
        
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = $processor($value);
        }
        
        return $result;
    }
    
    public function aggregate(array $data, string $field): array {
        $this->logger->info('Aggregating data', ['field' => $field]);
        
        $aggregated = [];
        foreach ($data as $item) {
            if (isset($item[$field])) {
                $key = $item[$field];
                $aggregated[$key] = ($aggregated[$key] ?? 0) + 1;
            }
        }
        
        return $aggregated;
    }
    
    public function filter(array $data, callable $predicate): array {
        return array_filter($data, $predicate);
    }
    
    public function transform(array $data, callable $transform): array {
        return array_map($transform, $data);
    }
    
    public function getStatistics(array $numbers): array {
        if (empty($numbers)) {
            return [
                'count' => 0,
                'sum' => 0,
                'average' => 0,
                'min' => null,
                'max' => null,
            ];
        }
        
        return [
            'count' => count($numbers),
            'sum' => array_sum($numbers),
            'average' => array_sum($numbers) / count($numbers),
            'min' => min($numbers),
            'max' => max($numbers),
            'formatted_sum' => CommonFunctions::formatNumber(array_sum($numbers)),
        ];
    }
}

// CLI usage
if (php_sapi_name() === 'cli') {
    $processor = new DataProcessor();
    
    // Example data
    $data = [
        ['name' => 'Alice', 'age' => 30, 'score' => 85],
        ['name' => 'Bob', 'age' => 25, 'score' => 92],
        ['name' => 'Charlie', 'age' => 35, 'score' => 78],
    ];
    
    echo "Original data:\n";
    echo json_encode($data, JSON_PRETTY_PRINT) . "\n\n";
    
    // Filter
    $filtered = $processor->filter($data, fn($item) => $item['age'] > 28);
    echo "Filtered (age > 28):\n";
    echo json_encode($filtered, JSON_PRETTY_PRINT) . "\n\n";
    
    // Transform
    $transformed = $processor->transform($data, fn($item) => [
        'name' => strtoupper($item['name']),
        'score' => $item['score'],
    ]);
    echo "Transformed:\n";
    echo json_encode($transformed, JSON_PRETTY_PRINT) . "\n\n";
    
    // Statistics
    $scores = array_column($data, 'score');
    $stats = $processor->getStatistics($scores);
    echo "Statistics:\n";
    echo json_encode($stats, JSON_PRETTY_PRINT) . "\n";
}

