<?php

class View
{
    protected string $filePath ;

    public function __construct(protected string $path)
    {
        $this->filePath = $path;

    }
    public function render()
    {
        include_once VIEW_PATH.'/'.$this->filePath.'.php';
    }
}
