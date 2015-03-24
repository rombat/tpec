<?php

class Categorie extends Eloquent {

    use SoftDeletingTrait;

	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required',
		'description' => 'required'
	);
}
