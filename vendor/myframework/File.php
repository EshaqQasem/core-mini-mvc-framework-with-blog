<?php

namespace myframework;

class File
{
    private string $root;

    /**
     * @param string $root
     */
    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /**
     * @param $file
     * @return bool
     */
    public function exists($file):bool
    {
        return file_exists($file);
    }

    public function require($file)
    {
        require $file;
    }

    public function concat($path)
    {
        return $this->root . DIRECTORY_SEPARATOR .
             str_replace(['/','\\'],DIRECTORY_SEPARATOR,$path);
    }



}