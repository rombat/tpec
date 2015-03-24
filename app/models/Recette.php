<?php



class Recette extends Eloquent {

    use SoftDeletingTrait;

	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required',
		'resume' => 'required',
		'description' => 'required',
		'temps_cuisson' => '',
		'temps_repos' => '',
		'difficulte' => 'required',
		'nombre_personnes' => 'required',
		'prix' => 'required'
	);
}
