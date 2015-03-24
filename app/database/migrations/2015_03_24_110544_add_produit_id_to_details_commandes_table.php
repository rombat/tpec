<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddProduitIdToDetailsCommandesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('details_commandes', function(Blueprint $table) {
			$table->integer('recette_id')->nullable()->unsigned()->index();
            $table->foreign('recette_id')->references('id')->on('recettes')->onDelete('set null')->onUpdate('cascade');
            $table->integer('ingredient_id')->nullable()->unsigned()->index();
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
		Schema::table('details_commandes', function(Blueprint $table) {
            $table->dropForeign('details_commandes_recette_id_foreign');
			$table->dropColumn('recette_id');
            $table->dropForeign('details_commandes_ingredient_id_foreign');
            $table->dropColumn('ingredient_id');
		});
	}

}
