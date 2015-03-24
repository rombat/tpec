<?php

class Commande extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'total' => 'required',
		'statut' => 'required'
	);
}
