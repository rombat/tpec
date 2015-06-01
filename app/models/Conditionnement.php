<?php

class Conditionnement extends Eloquent {
    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    public static $rules = array(
		'nom' => 'required|unique:conditionnements,nom'
	);

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('Ingredient')->withPivot('prix');
    }
}
