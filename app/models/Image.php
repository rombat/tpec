<?php

class Image extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required'
	);
}
