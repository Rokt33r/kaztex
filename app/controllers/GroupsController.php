<?php
class GroupsController extends BaseController{
	protected $user, $group;

	function __construct(User $user, Group $group){
		$this->user = $user;
		$this->group = $group;

	}
	function index(){
		$group = $this->group->find(1);
		return $group->master;
	}

}
