<?php

namespace Raakkan\PhpTailwind\Concerns;

use InvalidArgumentException;

trait HasBladeFiles
{
    protected $bladeFiles = [];

    /**
     * Add one or more Blade files to be processed.
     *
     * @param string|array $files
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addBladeFiles($files)
    {
        $files = is_array($files) ? $files : [$files];

        foreach ($files as $file) {
            if (!file_exists($file)) {
                throw new InvalidArgumentException("File does not exist: {$file}");
            }
            $this->bladeFiles[] = $file;
        }

        return $this;
    }

    /**
     * Get all CSS classes from the added Blade files.
     *
     * @return array
     */
    public function getClassesFromBladeFiles()
    {
        $allClasses = [];

        foreach ($this->bladeFiles as $file) {
            $content = file_get_contents($file);
            
            // Match classes in standard HTML attributes
            preg_match_all('/class=["\']([^"\']*)["\']/', $content, $matches);
            
            // Match classes in Blade directives (e.g., @class(['foo' => true]))
            preg_match_all('/@class\(\[(.*?)\]\)/', $content, $bladeMatches);
            
            if (isset($matches[1])) {
                $fileClasses = implode(' ', $matches[1]);
                $allClasses = array_merge($allClasses, explode(' ', $fileClasses));
            }
            
            if (isset($bladeMatches[1])) {
                foreach ($bladeMatches[1] as $bladeMatch) {
                    preg_match_all('/[\'"]([^\'"]+)[\'"]/', $bladeMatch, $bladeClasses);
                    if (isset($bladeClasses[1])) {
                        $allClasses = array_merge($allClasses, $bladeClasses[1]);
                    }
                }
            }
        }

        return array_unique(array_filter($allClasses));
    }

    /**
     * Get the list of added Blade files.
     *
     * @return array
     */
    public function getBladeFiles()
    {
        return $this->bladeFiles;
    }
}