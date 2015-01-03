<?php

use Kaztex\Files\FileManager;

class UserFilesController extends BaseController{

    /**
     * @var FileManager
     */
    protected $fileManager;

    /**
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager){
        $this->fileManager = $fileManager;
    }

    /**
     * Same as the unix command, 'ls'
     * get a file or a directory information with the path
     * @param string $path
     * @return
     */
    public function ls($path = ''){

        $user = Auth::user();
        $rootPath = "users/{$user->id}";

        $fileInfo = \Kaztex\Files\FileSys::ls($rootPath.$path);
        if(empty($fileInfo)){
            return Response::make(['error'=>'Invalid path'], 400);
        }

        return $fileInfo;
    }

    /**
     * @return array
     */
    public function index(){
        $user = Auth::user();

        $rootPath = "users/{$user->id}";

        $files = $this->fileManager->fetchFileMap($rootPath);

        return ['files'=>$files];
    }


    /**
     * @param $slag
     * @return array
     */
    public function show($slag){
        $user = Auth::user();

        $path = "users/{$user->id}/{$slag}";

        $file = $this->fileManager->fetchFile($path);

        if(empty($file)){
            return Response::make(['file'=>null], 400);
        }

        if($file['type']==='file' && Input::get('mode')==='load'){
            $data = base64_encode(Flysystem::read($path));
            return ['file'=>$file,'data'=>$data];
        }

        return ['file'=>$file];

    }

    /**
     * @param $var
     * @return bool
     */
    function test($var){
        return true;
    }

    /**
     * @param $var
     * @return bool
     */
    function can_be_string($var) {
        return $var === is_scalar($var) || is_callable([$var, '__toString']);
    }

    /**
     * @param string $slag
     * @return array
     */
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

    /**
     * @param $slag
     * @return array
     */
    public function destroy($slag){
        $user = Auth::user();

        $path = "users/{$user->id}/{$slag}";

        if(!$this->fileManager->deleteFile($path)){
            return Response::make(['file'=>null], 400);
        }

        return ['message'=>'OK'];
    }
}