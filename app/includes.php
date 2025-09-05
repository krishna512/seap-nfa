<?php

/**
 * requires all ".php" files from dir defined in "include_paths" at first level.
 * @param array $include_paths will be [__DIR__.'/inc'];
 */
function requires_paths_files($include_dir_paths)
{
    foreach ($include_dir_paths as $key => $file_path) {
        if (!file_exists($file_path)) {
            continue;
        }
        foreach (new \DirectoryIterator($file_path) as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }
            $fileExtension = $file->getExtension(); // Get the current file extension
            if ($fileExtension != "php") {
                continue;
            }
            // $fileName = $file->getFilename(); // Get the full name of the current file.
            $filePath = $file->getPathname(); // Get the full path of the current file
            if ($filePath) {
                require_once $filePath;
            }
        }
    }
}


/**
 * requires all ".php" files from dir defined in "lib" at first level.
 */
function require_lib_files($lib_files_names)
{
    foreach ($lib_files_names as $key => $lib_fileName) {
        $libfile =  dirname(__FILE__) . '/lib/' . $lib_fileName . '.php';
        if (file_exists($libfile)) {
            require_once $libfile;
        }
    }
}



/**
 * Set up lib
 * As requires in the orders.
 */
$lib_files_names = [
    'class-vite-config',
    'class-yipl-securities',
    'class-yipl-user-role',
    'class-yipl-extra',
    'class-yipl-breadcrumb'
];
require_lib_files($lib_files_names);


/**
 * 
 */
$include_paths = [
    __DIR__ . '/blocks',
    __DIR__ . '/pattern',
    __DIR__ . '/functions',
    __DIR__ . '/endpoint',
    __DIR__ . '/inc',
    __DIR__ . '/shortcodes',
];
requires_paths_files($include_paths);
