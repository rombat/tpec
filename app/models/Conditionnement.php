<?php

class Conditionnement extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required'
	);

    public function ingredients()
    {
        return $this->belongsToMany('Ingredient')->withPivot('prix');
    }
}
