<?php
class PostApiController extends BaseController{

	protected $post;

	function __construct(Post $post){
		$this->post = $post;
	}

	function make(){
		$title = Input::get('title');
		if(empty($title)){
			$message = 'Need a title to make a new post.';
			return Response::make(['message'=>$message], 400);
		}
		$user = Auth::user();
		if(empty($user)){
			$message = 'Need to sign in to make a new post';
			return Response::make(['message'=>$message], 400);
		}
		$post = $this->post->create([
			'title'=>$title,
			'user_id'=>$user->id,
			'group_id'=>0
			]);
		$message = "Successfully created.";
		$data = ['post'=>$post];
		return Response::make(['message'=>$message, 'data'=>$data]);
	}

	function show($post_id){
		$post = $this->post->find($post_id);
		if(empty($post)){
			$message = "No Post found with the given id";
			return Response::make(['message'=>$message], 404);
		}
		$message = "Successfully found.";
		$data = ['post'=>$post];
		return Response::make(['message'=>$message,'data'=>$data], 200);
	}

	function destroy($post_id){
		$post = $this->post->find($post_id);
		if(empty($post)){
			$message = "No Post found with the given id";
			return Response::make(['message'=>$message], 404);
		}
		$post->delete();
		$message = "Successfully deleted.";
		$data = ['post'=>$post];
		return Response::make(['message'=>$message,'data'=>$data], 200);
	}

	function editBody($post_id){
		$post = $this->post->find($post_id);
		$post->body = Input::get('body');
		$post->save();
		$message = "Successfully edited";
		$data = ['post'=>$post];
		return Response::make(['message'=>$message, 'data'=>$data]);
	}
	function editTitle($post_id){
		$post = $this->post->find($post_id);
		$post->title = Input::get('title');
		$post->save();
		$message = "Successfully edited";
		$data = ['post'=>$post];
		return Response::make(['message'=>$message, 'data'=>$data]);
	}
	function editDrawings($post_id){
		$post = $this->post->find($post_id);
		$post->drawings = Input::get('drawings');
		$post->save();
		$message = "Successfully edited";
		$data = ['post'=>$post];
		return Response::make(['message'=>$message, 'data'=>$data]);
	}
}
