<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipTablesAndSetForeignKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_groups', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');
			$table->timestamps();
		});

		Schema::create('post_groups', function($table){
			$table->increments('id');
			$table->integer('post_id')->unsigned();
			$table->foreign('post_id')->references('id')->on('posts');
			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');
			$table->timestamps();
		});

		Schema::table('groups', function($table){
			$table->foreign('master_id')->references('id')->on('users');
		});

		Schema::table('posts', function($table){
			$table->foreign('user_id')->references('id')->on('users');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('posts', function($table){
			$table->dropForeign('posts_user_id_foreign');
		});

		Schema::table('groups', function($table){
			$table->dropForeign('groups_master_id_foreign');
		});

		Schema::drop('post_groups');

		Schema::drop('user_groups');
	}

}
