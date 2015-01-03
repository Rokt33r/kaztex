<?php namespace Kaztex\Files;

use GrahamCampbell\Flysystem\Facades\Flysystem;

class FileSys {

    public static function ls($path){

        // return null when the file doesn't exist.
        if(!Flysystem::has($path)){
            return null;
        }
        $file = Flysystem::get($path);

        // check if it is a file
        if($file->isFile()){
            $result = [
                'path'=>$file->getPath(),
                'basename'=>static::getBasename($file->getPath()),
                'type'=>'file',
                'size'=>$file->getSize(),
                'timestamp'=>$file->getTimestamp()
            ];

            return $result;
        }

        if($file->isDir()){
            $sub_files = Flysystem::listContents($path, false);
            $fetched_sub_files = [];
            foreach($sub_files as $sub_file){
                if($sub_file['type']=='dir'){
                    $sub_file = static::ls($sub_file['path']);
                }
                array_push($fetched_sub_files, $sub_file);
            }
            $result = [
                'path'=>$file->getPath(),
                'basename'=>static::getBasename($file->getPath()),
                'type'=>'dir',
                'sub_files'=>$fetched_sub_files
            ];

            return $result;
        }


        return null;
    }

    public static function getBasename($path){
        $array = explode('/',$path);

        return $array[count($array)-1];
    }
}