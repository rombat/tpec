<?php

class Categorie extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required',
		'description' => 'required',
		'active' => 'boolean',
		'image' => 'image|max:2000',
		'parent_id' => 'exists:categories,id'
	);

    public function recettes()
    {
        return $this->hasMany('Recette');
    }

    public function categorieParente()
    {
        return $this->belongsTo('Categorie', 'parent_id');
    }

    public function sousCategories()
    {
        return $this->hasMany('Categorie', 'parent_id');
    }
}
