<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecettesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recettes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->text('resume');
			$table->text('description');
			$table->time('temps_preparation');
			$table->time('temps_cuisson')->nullable();
			$table->tinyInteger('difficulte');
			$table->tinyInteger('nb_personnes');
			$table->float('prix');
			$table->boolean('active');
			$table->string('image');
			$table->integer('categorie_id')->unsigned()->nullable()->index();
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
		Schema::drop('recettes');
	}

}
