<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToRecettesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('recettes', function(Blueprint $table) {
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
        });

	}

}
