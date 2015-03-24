<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotImageIngredientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('image_ingredient', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('image_id')->unsigned()->nullable()->index();
			$table->integer('ingredient_id')->unsigned()->nullable()->index();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('set null')->onUpdate('cascade');
            $table->boolean('principale');
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
		Schema::drop('image_ingredient');
	}

}
