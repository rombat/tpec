<?php

use Carbon\Carbon;

class Recette extends Eloquent {
    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    public static $rules = array(
		'nom' => 'required',
		'resume' => 'required',
		'description' => 'required',
		'temps_preparation' => 'required|date_format:H:i:s',
		'temps_cuisson' => 'date_format:H:i:s',
		'difficulte' => 'required|between:1,5',
		'nb_personnes' => 'required',
		'prix' => 'required|numeric',
		'active' => 'required',
        'image' => 'image|max:2000',
		'categorie_id' => 'required|exists:categories,id',
        'ingredients:quantite:*' => 'required|numeric',
        'ingredients:id:*' => 'required|exists:ingredients,id',
	);

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie()
    {
        return $this->belongsTo('Categorie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('Ingredient')->withPivot('quantite', 'unite');
    }


    /**
     * Formate une heure rentrée au format hh:mm:ss en une chaine de caractère formatée en [$i]h [$j]min
     * @param $time
     * @return string
     */
    public static function timeFormat($time) {
        $timeArray = explode(':', $time);
        $timeFormat = ($timeArray[0] != '00') ? $timeArray[0] . 'h ' : '';
        $timeFormat .= $timeArray[1] . 'min';
        return $timeFormat;
    }

    /**
     * Calcule le prix de revient "à la louche" d'une recette, en se basant sur les ingrédients les plus chers du site utilisés dans la recette
     * @return int
     */
    public function prixRevient()
    {
        $prix = 0;
        foreach($this->ingredients as $ingredient) {
            $prix += $ingredient->conditionnements()->orderBy('prix', 'desc')->first()->pivot->prix;
        }
        return $prix;
    }
}
