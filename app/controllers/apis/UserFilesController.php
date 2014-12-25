<?php

use Kaztex\Files\FileManager;

class UserFilesController extends BaseController{

    protected $fileManager;

    public function __construct(FileManager $fileManager){
        $this->fileManager = $fileManager;
    }

    public function index(){
        $user = Auth::user();

        $rootPath = "users/{$user->id}";

        $files = $this->fileManager->fetchFileMap($rootPath);

        return ['files'=>$files];
    }


    public function show($slag){
        $user = Auth::user();

        $path = "users/{$user->id}/{$slag}";

        $file = $this->fileManager->fetchFile($path);

        if(empty($file)){
            return Response::make(['file'=>null], 400);
        }

        if($file['type']==='file' && Input::get('order')==='load'){
            $data = Flysystem::read($path);
            return ['file'=>$file,'data'=>$data];
        }

        return ['file'=>$file];

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