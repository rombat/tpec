<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRecetteIdToCommentairesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commentaires', function(Blueprint $table) {
			$table->integer('recette_id')->unsigned()->nullable()->index();
            $table->foreign('recette_id')->references('id')->on('recettes')->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commentaires', function(Blueprint $table) {
            $table->dropForeign('commentaires_recette_id_foreign');
			$table->dropColumn('recette_id');
		});
	}

}
