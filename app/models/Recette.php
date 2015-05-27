<?php

use Carbon\Carbon;

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
        'ingredients:quantite:*' => 'required|numeric',
        'ingredients:unite:*' => 'required',
        'ingredients:id:*' => 'required|exists:ingredients,id',
	);

    public function categorie()
    {
        return $this->belongsTo('Categorie');
    }

    public function ingredients()
    {
        return $this->belongsToMany('Ingredient')->withPivot('quantite', 'unite');
    }

    public function getTempsCuissonAttribute($time) {
        return self::timeFormat($time);
    }

    public function getTempsPreparationAttribute($time) {
        return self::timeFormat($time);
    }

    public static function timeFormat($time) {
        $timeArray = explode(':', $time);
        $timeFormat = ($timeArray[0] != '00') ? $timeArray[0] . 'h ' : '';
        $timeFormat .= $timeArray[1] . 'min';
        return $timeFormat;
    }
}
