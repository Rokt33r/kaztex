<?php

class Post extends Eloquent{

	protected $table = 'posts';

	protected $fillable = ['user_id', 'group_id', 'scope', 'title', 'body', 'drawings'];

	public function user(){
		return $this->belongsTo('User');
	}
}