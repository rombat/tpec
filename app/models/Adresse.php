<?php

class Adresse extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'type' => 'required',
		'adresse' => 'required',
		'code_postal' => 'required',
		'ville' => 'required'
	);
}
