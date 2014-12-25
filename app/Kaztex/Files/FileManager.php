<?php namespace Kaztex\Files;

use \Flysystem;

class FileManager {

    protected $fly;

    public function __construct(Flysystem $fly){
        $this->fly = $fly;
    }

    public function fetchFileMap($path){
        $files = Flysystem::listContents($path, false);
        $result = [];
        foreach($files as $file){
            if($file['type']=='dir'){
                $subFiles = $this->fetchFileMap($file['path']);
                $file['subFiles'] = $subFiles;
            }
            array_push($result, array_only($file, ['type', 'path', 'basename', 'timestamp', 'size', 'subFiles']));
        }
        return $result;
    }

    public function fetchFile($path){
        if(!Flysystem::has($path)){
            return null;
        }

        $file = Flysystem::get($path);

        $result = [];

        $result['basename'] = $this->getBasename($path);
        $result['path'] = $path =  $file->getPath();
        $result['type'] = $file->getType();

        if($file->isFile()){
            $result['timestamp'] = $file->getTimestamp();
            $result['size'] = $file->getSize();
        }

        if($file->isDir()){
            $result['subFiles'] = $this->fetchFileMap($path);
        }

        return $result;
    }
    public function getBasename($path){
        $array = explode('/',$path);

        return $array[count($array)-1];
    }
}