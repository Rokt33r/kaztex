<?php

class Group extends Eloquent{

	protected $table = 'groups';

	protected $fillable = ['master_id', 'name', 'description'];

	public function users(){
		return $this->belongsToMany('User', 'users_groups', 'user_id', 'id');
	}
	public function master(){
		return $this->belongsTo('User', 'master_id');
	}

}
