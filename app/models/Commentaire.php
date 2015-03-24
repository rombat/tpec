<?php

class Commentaire extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required',
		'commentaire' => 'required',
		'note' => 'required'
	);
}
