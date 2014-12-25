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
        if(Input::get('mode') ==='upload'){

            $user = Auth::user();

            $file = Input::file('file');

            $filename = Input::get('filename');
            if(empty($filename)){
                $filename = $file->getClientOriginalName();
            }

            $dirname = Input::get('dirname');

            if(!empty($slag)){
                $dirname = $slag;
            }

            $path = "users/{$user->id}/{$dirname}/{$filename}";

            $error = $this->fileManager->uploadFile($path, $file);
            if($error){
                return Response::make($error->getMessage(), 400);
            }

        }else{
            $user = Auth::user();

            $path = "users/{$user->id}/{$slag}";

            Flysystem::write($path, Input::get('content'));

        }

        return ['message'=>'OK'];
    }

    public function destroy($slag){
        $user = Auth::user();

        $path = "users/{$user->id}/{$slag}";

        if(!$this->fileManager->deleteFile($path)){
            return Response::make(['file'=>null], 400);
        }

        return ['message'=>'OK'];
    }
}