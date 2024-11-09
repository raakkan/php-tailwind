<?php

namespace Raakkan\PhpTailwind\Concerns;

use InvalidArgumentException;

trait HasHtmlFiles
{
    protected $htmlFiles = [];

    /**
     * Add one or more HTML files to be processed.
     *
     * @param  string|array  $files
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addHtmlFiles($files)
    {
        $files = is_array($files) ? $files : [$files];

        foreach ($files as $file) {
            if (! file_exists($file)) {
                throw new InvalidArgumentException("File does not exist: {$file}");
            }
            $this->htmlFiles[] = $file;
        }

        return $this;
    }

    /**
     * Get all CSS classes from the added HTML files.
     *
     * @return array
     */
    public function getClassesFromHtmlFiles()
    {
        $allClasses = [];

        foreach ($this->htmlFiles as $file) {
            $content = file_get_contents($file);
            preg_match_all('/class=["\']([^"\']*)["\']/', $content, $matches);

            if (isset($matches[1])) {
                $fileClasses = implode(' ', $matches[1]);
                $allClasses = array_merge($allClasses, explode(' ', $fileClasses));
            }
        }

        return array_unique(array_filter($allClasses));
    }

    /**
     * Get the list of added HTML files.
     *
     * @return array
     */
    public function getHtmlFiles()
    {
        return $this->htmlFiles;
    }
}
