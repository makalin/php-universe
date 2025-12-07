#!/usr/bin/env php
<?php

/**
 * Project Scaffolder
 * 
 * Generates a new php-universe project structure with all necessary files.
 * Usage: php tools/project-scaffold.php <project-name> [--target=<target>]
 */

class ProjectScaffolder {
    private string $projectName;
    private string $projectDir;
    private array $targets = ['native', 'wasm', 'ios', 'embedded'];
    private array $enabledTargets = ['native'];
    
    public function __construct(string $projectName, array $enabledTargets = []) {
        $this->projectName = $projectName;
        $this->projectDir = getcwd() . '/' . $projectName;
        $this->enabledTargets = $enabledTargets ?: ['native'];
    }
    
    public function scaffold(): void {
        echo "🚀 Scaffolding project: {$this->projectName}\n";
        
        if (is_dir($this->projectDir)) {
            throw new RuntimeException("Directory {$this->projectDir} already exists");
        }
        
        $this->createDirectoryStructure();
        $this->createComposerJson();
        $this->createUniverseToml();
        $this->createMainPhp();
        $this->createGitignore();
        $this->createReadme();
        
        echo "✅ Project scaffolded successfully!\n";
        echo "\nNext steps:\n";
        echo "  cd {$this->projectName}\n";
        echo "  composer install\n";
        echo "  px build --target=native\n";
    }
    
    private function createDirectoryStructure(): void {
        mkdir($this->projectDir, 0755, true);
        mkdir($this->projectDir . '/src', 0755, true);
        mkdir($this->projectDir . '/tests', 0755, true);
        mkdir($this->projectDir . '/dist', 0755, true);
    }
    
    private function createComposerJson(): void {
        $composer = [
            'name' => strtolower(str_replace(' ', '-', $this->projectName)),
            'description' => "A php-universe project",
            'type' => 'project',
            'require' => [
                'php' => '>=8.2'
            ],
            'autoload' => [
                'files' => ['src/main.php']
            ],
            'autoload-dev' => [
                'psr-4' => [
                    'Tests\\' => 'tests/'
                ]
            ]
        ];
        
        file_put_contents(
            $this->projectDir . '/composer.json',
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"
        );
    }
    
    private function createUniverseToml(): void {
        $toml = "[project]\n";
        $toml .= "name = \"{$this->projectName}\"\n";
        $toml .= "version = \"1.0.0\"\n";
        $toml .= "entry = \"src/main.php\"\n";
        $toml .= "description = \"A php-universe application\"\n\n";
        
        foreach ($this->targets as $target) {
            $enabled = in_array($target, $this->enabledTargets) ? 'true' : 'false';
            $toml .= "[targets.{$target}]\n";
            $toml .= "enabled = {$enabled}\n";
            
            match($target) {
                'native' => $toml .= "optimization = \"O3\"\noutput = \"dist/{$this->projectName}\"\nstrip = true\n\n",
                'wasm' => $toml .= "expose_functions = []\nmemory_size = \"8MB\"\noptimization = \"O3\"\n\n",
                'ios' => $toml .= "bundle_id = \"com.example." . strtolower($this->projectName) . "\"\nminimum_ios_version = \"13.0\"\n\n",
                'embedded' => $toml .= "platform = \"esp32\"\nflash_size = \"4MB\"\n\n",
            };
        }
        
        file_put_contents($this->projectDir . '/universe.toml', $toml);
    }
    
    private function createMainPhp(): void {
        $php = <<<'PHP'
<?php

/**
 * Main entry point for {$this->projectName}
 */

function greet(string $name = "World"): string {
    return "Hello, {$name}!";
}

function main(): void {
    if (php_sapi_name() === 'cli') {
        $name = $argv[1] ?? "World";
        echo greet($name) . PHP_EOL;
    } else {
        echo greet() . PHP_EOL;
    }
}

if (php_sapi_name() === 'cli' && !defined('PHPUNIT_COMPOSER_INSTALL')) {
    main();
}
PHP;
        
        $php = str_replace('{$this->projectName}', $this->projectName, $php);
        file_put_contents($this->projectDir . '/src/main.php', $php);
    }
    
    private function createGitignore(): void {
        $gitignore = <<<'GITIGNORE'
/vendor/
/dist/
/.phpunit.result.cache
/composer.lock
*.wasm
*.o
*.a
.DS_Store
GITIGNORE;
        
        file_put_contents($this->projectDir . '/.gitignore', $gitignore);
    }
    
    private function createReadme(): void {
        $readme = <<<README
# {$this->projectName}

A php-universe project.

## Quick Start

\`\`\`bash
composer install
px build --target=native
./dist/{$this->projectName}
\`\`\`

## Building

\`\`\`bash
# Native
px build --target=native

# WebAssembly
px build --target=wasm

# iOS
px build --target=ios

# Embedded
px build --target=embedded
\`\`\`
README;
        
        file_put_contents($this->projectDir . '/README.md', $readme);
    }
}

// CLI entry point
if (php_sapi_name() === 'cli') {
    if ($argc < 2) {
        echo "Usage: php tools/project-scaffold.php <project-name> [--target=<target>]\n";
        echo "Example: php tools/project-scaffold.php my-app --target=native --target=wasm\n";
        exit(1);
    }
    
    $projectName = $argv[1];
    $targets = [];
    
    for ($i = 2; $i < $argc; $i++) {
        if (str_starts_with($argv[$i], '--target=')) {
            $targets[] = substr($argv[$i], 9);
        }
    }
    
    try {
        $scaffolder = new ProjectScaffolder($projectName, $targets);
        $scaffolder->scaffold();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

