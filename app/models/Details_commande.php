<?php

class Details_commande extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'prix' => 'required',
		'quantite' => 'required'
	);
}
