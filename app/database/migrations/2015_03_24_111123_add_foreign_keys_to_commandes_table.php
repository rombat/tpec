<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommandesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commandes', function(Blueprint $table) {
			$table->integer('adresse_facturation_id')->unsigned()->nullable()->index();
            $table->foreign('adresse_facturation_id')->references('id')->on('adresses')->onDelete('set null')->onUpdate('cascade');
			$table->integer('adresse_livraison_id')->unsigned()->nullable()->index();
            $table->foreign('adresse_livraison_id')->references('id')->on('adresses')->onDelete('set null')->onUpdate('cascade');
			$table->integer('client_id')->unsigned()->nullable()->index();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commandes', function(Blueprint $table) {
            $table->dropForeign('commandes_adresse_facturation_id_foreign');
            $table->dropForeign('commandes_adresse_livraison_id_foreign');
            $table->dropForeign('commandes_client_id_foreign');
			$table->dropColumn('adresse_facturation_id');
			$table->dropColumn('adresse_livraison_id');
			$table->dropColumn('client_id');
		});
	}

}
