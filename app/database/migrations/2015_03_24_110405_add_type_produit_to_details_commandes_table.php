<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTypeProduitToDetailsCommandesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('details_commandes', function(Blueprint $table) {
			$table->string('type_produit');
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
			$table->dropColumn('type_produit');
		});
	}

}
