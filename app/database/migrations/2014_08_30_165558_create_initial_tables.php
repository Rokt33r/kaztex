<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
		    $table->increments('id');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('name');
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('groups', function($table)
		{
			$table->increments('id');
			$table->integer('master_id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->timestamps();
		});

		Schema::create('posts', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('group_id')->unsigned();
			$table->integer('scope');
			$table->string('title');
			$table->text('body');
			$table->timestamps();
		});

		Schema::create('tags', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tags');
		Schema::drop('posts');
		Schema::drop('groups');
		Schema::drop('users');
	}

}
