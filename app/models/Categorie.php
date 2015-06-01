<?php

class Categorie extends Eloquent {
    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    public static $rules = array(
		'nom' => 'required|unique:categories,nom',
		'description' => 'required',
		'active' => 'required',
		'image' => 'image|max:2000',
		'parent_id' => 'exists:categories,id'
	);

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recettes()
    {
        return $this->hasMany('Recette');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorieParente()
    {
        return $this->belongsTo('Categorie', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousCategories()
    {
        return $this->hasMany('Categorie', 'parent_id');
    }

    /**
     * Retourne l'ensemble des recettes existantes pour une catégorie (inclus aussi celles des sous catégories)
     * @return \Illuminate\Database\Eloquent\Collection|static
     */
    public function recettesTotales()
    {
        $recettes = $this->recettes;
        foreach($this->sousCategories as $sousCat) {
           $recettes = $recettes->merge($sousCat->recettes);
        }
        return $recettes;
    }

    /**
     * Retourne l'ensemble des ingrédients utilisés dans une catégorie
     * @return \Illuminate\Database\Eloquent\Collection|static
     */
    public function ingredients()
    {
        $ingredients = new \Illuminate\Database\Eloquent\Collection();
        foreach ($this->recettesTotales() as $recette) {
            $ingredients = $ingredients->merge($recette->ingredients);
        }
        return $ingredients;
    }

}
