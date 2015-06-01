<?php

class Ingredient extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'nom' => 'required|unique:ingredients,nom',
		'description' => 'required',
		'active' => 'required',
        'image' => 'image|max:2000',
        'conditionnements:id:*' => 'required|exists:conditionnements,id',
        'conditionnements:prix:*' => 'required|numeric',

	);

    public function conditionnements()
    {
        return $this->belongsToMany('Conditionnement')->withPivot('prix');
    }

    public function recettes()
    {
        return $this->belongsToMany('Recette')->withPivot('quantite', 'unite');
    }

    public static function unitesDispos()
    {
        $unites = DB::table('ingredient_recette')->select(['unite'])->distinct()->get();
        return $unites;
    }
}
