<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('RecettesTableSeeder');
		$this->call('IngredientsTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('CommentairesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('AdressesTableSeeder');
		$this->call('CommandesTableSeeder');
		$this->call('Details_commandesTableSeeder');
		$this->call('ImagesTableSeeder');
	}

}
