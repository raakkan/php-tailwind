<?php

namespace Raakkan\PhpTailwind;

class TailwindClassDiscovery
{
    public static function discoverClasses(): array
    {
        $classTypes = [];
        $tailwindDir = __DIR__.'/Tailwind';

        self::discoverFromSubdirectories($tailwindDir, $classTypes);
        self::discoverFromRootDirectory($tailwindDir, $classTypes);

        return $classTypes;
    }

    private static function discoverFromSubdirectories(string $tailwindDir, array &$classTypes): void
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($tailwindDir));
        $regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($regex as $file) {
            $filePath = $file[0];
            if (strpos($filePath, 'Static') !== false) {
                continue;
            }

            $className = self::extractClassNameFromFile($filePath);
            if ($className && self::isValidTailwindClass($className)) {
                $classTypes[] = $className;
            }
        }
    }

    private static function discoverFromRootDirectory(string $tailwindDir, array &$classTypes): void
    {
        $tailwindClasses = glob($tailwindDir.'/*.php');
        foreach ($tailwindClasses as $filePath) {
            $className = self::extractClassNameFromFile($filePath);
            if ($className && self::isValidTailwindClass($className)) {
                $classTypes[] = $className;
            }
        }
    }

    private static function extractClassNameFromFile(string $filePath): ?string
    {
        $content = file_get_contents($filePath);
        if (preg_match('/namespace\s+(.*?);/', $content, $namespaceMatches) &&
            preg_match('/class\s+(\w+)/', $content, $classMatches)) {
            return $namespaceMatches[1].'\\'.$classMatches[1];
        }

        return null;
    }

    private static function isValidTailwindClass(string $className): bool
    {
        if (! class_exists($className)) {
            return false;
        }

        $reflectionClass = new \ReflectionClass($className);

        return $reflectionClass->isSubclassOf(AbstractTailwindClass::class);
    }
}
