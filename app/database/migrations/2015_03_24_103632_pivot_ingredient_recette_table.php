<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotIngredientRecetteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingredient_recette', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ingredient_id')->unsigned()->nullable()->index();
			$table->integer('recette_id')->unsigned()->nullable()->index();
			$table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('recette_id')->references('id')->on('recettes')->onDelete('set null')->onUpdate('cascade');
            $table->tinyInteger('quantite');
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
		Schema::drop('ingredient_recette');
	}

}
