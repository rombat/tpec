<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCategorieIdToProduitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recettes', function(Blueprint $table) {
			$table->integer('categorie_id')->unsigned()->nullable()->index();
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('recettes', function(Blueprint $table) {
            $table->dropForeign('recettes_categorie_id_foreign');
			$table->dropColumn('categorie_id');
		});
	}

}
