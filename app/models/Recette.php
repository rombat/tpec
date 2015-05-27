<?php

class Recette extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required',
		'resume' => 'required',
		'description' => 'required',
		'temps_preparation' => 'required|date_format:H:i:s',
		'temps_cuisson' => 'date_format:H:i:s',
		'difficulte' => 'required|between:1,5',
		'nb_personnes' => 'required',
		'prix' => 'required|numeric',
		'active' => 'boolean',
        'image' => 'image|max:2000',
		'categorie_id' => 'required|exists:categories,id',
        'ingredients' => 'required|array'
	);

    public function categorie()
    {
        return $this->belongsTo('Categorie');
    }

    public function ingredients()
    {
        return $this->belongsToMany('Ingredient')->withPivot('quantite', 'unite');
    }
}
