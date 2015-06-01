<?php

class Categorie extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required|unique:categories,nom',
		'description' => 'required',
		'active' => 'required',
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

    public function recettesTotales()
    {
        $recettes = $this->recettes;
        foreach($this->sousCategories as $sousCat) {
           $recettes = $recettes->merge($sousCat->recettes);
        }
        return $recettes;
    }

    public function ingredients()
    {
        $ingredients = new \Illuminate\Database\Eloquent\Collection();
        foreach ($this->recettesTotales() as $recette) {
            $ingredients = $ingredients->merge($recette->ingredients);
        }
        return $ingredients;
    }

}
