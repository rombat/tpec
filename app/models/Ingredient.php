<?php

class Ingredient extends Eloquent {
    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    public static $rules = array(
		'nom' => 'required|unique:ingredients,nom',
		'description' => 'required',
		'active' => 'required',
        'image' => 'image|max:2000',
        'conditionnements:id:*' => 'required|exists:conditionnements,id',
        'conditionnements:prix:*' => 'required|numeric',

	);

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conditionnements()
    {
        return $this->belongsToMany('Conditionnement')->withPivot('prix');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recettes()
    {
        return $this->belongsToMany('Recette')->withPivot('quantite', 'unite');
    }


    /**
     * Retourne une collection des unités déja rentrées pour les ingrédients
     * @return \Illuminate\Database\Eloquent\Collection|static
     */
    public static function unitesDispos()
    {
        $unites = DB::table('ingredient_recette')->select(['unite'])->distinct()->get();
        return $unites;
    }
}
