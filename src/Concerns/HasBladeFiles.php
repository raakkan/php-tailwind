<?php

namespace Raakkan\PhpTailwind\Concerns;

use InvalidArgumentException;

trait HasBladeFiles
{
    protected $bladeItems = [];

    /**
     * Add one or more Blade files or views to be processed.
     *
     * @param  string|array  $items
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addBladeFiles($items)
    {
        $items = is_array($items) ? $items : [$items];

        foreach ($items as $item) {
            if ($this->isValidBladeItem($item)) {
                $this->bladeItems[] = $item;
            } else {
                throw new InvalidArgumentException("Invalid Blade file or view: {$item}");
            }
        }

        return $this;
    }

    /**
     * Check if the given item is a valid Blade file or view.
     *
     * @param  string  $item
     * @return bool
     */
    protected function isValidBladeItem($item)
    {
        return file_exists($item) || ($this->isLaravelInstalled() && view()->exists($item));
    }

    /**
     * Get all CSS classes from the added Blade files and views as a string.
     *
     * @return string
     */
    public function getClassesFromBladeFiles()
    {
        $allClasses = [];

        foreach ($this->bladeItems as $item) {
            $content = $this->getBladeContent($item);
            $allClasses = array_merge($allClasses, $this->extractClassesFromContent($content));
        }

        // Remove duplicates, filter out empty values, and join into a string
        return implode(' ', array_unique(array_filter($allClasses)));
    }

    /**
     * Get the content of a Blade file or view.
     *
     * @param  string  $item
     * @return string
     */
    protected function getBladeContent($item)
    {

        if (file_exists($item)) {
            return file_get_contents($item);
        }

        if ($this->isLaravelInstalled() && view()->exists($item)) {
            $factory = app('view');
            $finder = $factory->getFinder();

            try {
                // Try to find the view as is
                $path = $finder->find($item);
            } catch (\Exception $e) {
                // If not found, try to handle namespaced views

                $segments = explode('::', $item);
                if (count($segments) == 2) {
                    $namespace = $segments[0];
                    $view = $segments[1];
                    $hints = $finder->getHints();
                    if (isset($hints[$namespace])) {
                        foreach ($hints[$namespace] as $hint) {
                            $path = $hint.'/'.str_replace('.', '/', $view).'.blade.php';
                            if (file_exists($path)) {
                                break;
                            }
                        }
                    }
                }
            }

            if (! isset($path) || ! file_exists($path)) {
                throw new InvalidArgumentException("Unable to get content for: {$item}");
            }

            // Return the raw content of the view file
            return file_get_contents($path);
        }

        throw new InvalidArgumentException("Unable to get content for: {$item}");
    }

    /**
     * Extract CSS classes from content.
     *
     * @param  string  $content
     * @return array
     */
    protected function extractClassesFromContent($content)
    {
        $classes = [];

        // Match classes in standard HTML attributes
        preg_match_all('/class=["\']([^"\']*)["\']/', $content, $matches);

        // Match classes in Blade directives (e.g., @class(['foo' => true]))
        preg_match_all('/@class\(\[(.*?)\]\)/', $content, $bladeMatches);

        if (isset($matches[1])) {
            foreach ($matches[1] as $match) {
                // Remove any PHP variables or method calls
                $cleanMatch = preg_replace('/\{?\$[^}]+\}?/', '', $match);
                $cleanMatch = preg_replace('/\{\{.*?\}\}/', '', $cleanMatch);
                $fileClasses = explode(' ', $cleanMatch);
                $classes = array_merge($classes, array_filter($fileClasses));
            }
        }

        if (isset($bladeMatches[1])) {
            foreach ($bladeMatches[1] as $bladeMatch) {
                preg_match_all('/[\'"]([^\'"]+)[\'"]/', $bladeMatch, $bladeClasses);
                if (isset($bladeClasses[1])) {
                    $classes = array_merge($classes, array_filter($bladeClasses[1]));
                }
            }
        }

        // Remove any remaining items that contain PHP syntax
        $classes = array_filter($classes, function ($class) {
            return ! preg_match('/[\$\{\}]/', $class);
        });

        return $classes;
    }

    /**
     * Check if Laravel is installed.
     *
     * @return bool
     */
    protected function isLaravelInstalled()
    {
        return function_exists('app') && app()->bound('view');
    }

    /**
     * Get the list of added Blade files and views.
     *
     * @return array
     */
    public function getBladeFiles()
    {
        return $this->bladeItems;
    }

    public function getAllClassesFromBladeFiles()
    {
        return $this->getClassesFromBladeFiles();
    }
}
