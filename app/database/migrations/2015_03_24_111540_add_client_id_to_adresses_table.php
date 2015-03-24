<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddClientIdToAdressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('adresses', function(Blueprint $table) {
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
		Schema::table('adresses', function(Blueprint $table) {
            $table->dropForeign('adresses_client_id_foreign');
			$table->dropColumn('client_id');
		});
	}

}
