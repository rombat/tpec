<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddConditionnementIngredientTablePrix extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conditionnement_ingredient', function(Blueprint $table) {
			$table->float('prix');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conditionnement_ingredient', function(Blueprint $table) {
			$table->dropColumn('prix');
		});
	}

}
