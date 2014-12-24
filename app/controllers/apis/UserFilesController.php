<?php

class UserFilesController extends BaseController{

    public function index(){
        $user = Auth::user();

        $rootDir = Flysystem::listContents("users/{$user->id}", true);

        return ['files'=>$rootDir];
    }


    public function show($slag){
        $user = Auth::user();

        $path = "users/{$user->id}/{$slag}";

        if(!Flysystem::has($path)){
            return Response::make(['file'=>null], 400);
        }

        if(Input::get('order')==='load'){
            $data = Flysystem::read($path);
            return ['data'=>$data];
        }

        $file = Flysystem::get($path);

        $type = $file->getType();
        $path = $file->getPath();

        if($type === 'file'){
            $size = $file->getSize();
            $mime = $file->getMimetype();
            $timestamp = $file->getTimestamp();
        }

        return ['file'=>compact('type', 'path', 'mime', 'timestamp', 'size')];
    }

    public function store($slag = ''){
        $file = Input::file('file');
        $stream = fopen($file->getPathName(), 'r+');

        $name = $slag;
        if(empty($name)){
            $name = $file->getClientOriginalName();
        }

        $user = Auth::user();

        Flysystem::writeStream("users/{$user->id}/{$name}", $stream);
        fclose($stream);
        return ['message'=>'OK'];
    }

    public function destroy($slag){
        $user = Auth::user();

        $name = $slag;
        $path = "users/{$user->id}/{$name}";

        if(!Flysystem::has($path)){
            return Response::make(['file'=>null], 400);
        }


        if(Flysystem::get($path)->getType()==='dir'){
            Flysystem::deleteDir("users/{$user->id}/{$name}");
        }else{
            Flysystem::delete("users/{$user->id}/{$name}");
        }

        return ['message'=>'OK'];
    }
}