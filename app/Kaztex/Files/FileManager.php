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
            $file['path'] = preg_replace('/^users\/[0-9]+\//','',$file['path']);
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

    public function deleteFile($path){
        if(!Flysystem::has($path)){
            return false;
        }

        if(Flysystem::get($path)->isDir()){
            Flysystem::deleteDir($path);
        }else{
            Flysystem::delete($path);
        }
        return true;
    }

    public function uploadFile($path, $file){
        $stream = fopen($file->getPathName(), 'r+');

        try {
            Flysystem::writeStream($path, $stream);
        } catch (\Exception $e) {
            fclose($stream);
            return $e;
        }
        fclose($stream);
        return false;
    }

    public function resolveDuplicateName($path){
        $path_parts = pathinfo($path);

        $ext = array_key_exists('extension', $path_parts)?'.'.$path_parts['extension']:'';

        return "{$path_parts['dirname']}/{$path_parts['filename']} copy".$ext;
    }

    public function resolvePath($slag, $file){

    }
}