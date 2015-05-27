<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotConditionnementIngredientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conditionnement_ingredient', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('conditionnement_id')->unsigned()->nullable()->index();
			$table->integer('ingredient_id')->unsigned()->nullable()->index();
			$table->foreign('conditionnement_id')->references('id')->on('conditionnements')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('set null')->onUpdate('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conditionnement_ingredient');
	}

}
