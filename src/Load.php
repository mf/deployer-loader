<?php

namespace SourceBroker\DeployerLoader;

use SourceBroker\DeployerLoader\Utility\FileUtility;

/**
 * Class Load
 *
 * @package SourceBroker\DeployerLoader\Load
 */
class Load
{
    public function __construct($locationsToLoad)
    {
        $fileUtility = new FileUtility();
        foreach ($locationsToLoad as $locationToLoad) {
            if (!empty($locationToLoad['path'])) {
                $absolutePath = $this->projectRootAbsolutePath() . '/' . ltrim($locationToLoad['path'], '/\\');
                if (is_dir($absolutePath)) {
                    $fileUtility->requireFilesFromDirectoryReqursively(
                        $absolutePath,
                        !empty($locationToLoad['excludePattern']) ? $locationToLoad['excludePattern'] : null);
                } else {
                    $fileUtility->requireFile($absolutePath);
                }
            }
        }
    }

    /**
     * Return absolute path to project root so we can add it to relative pathes.
     *
     * @return bool|string
     */
    protected function projectRootAbsolutePath()
    {
        return realpath(__DIR__ . '/../../../../');
    }
}