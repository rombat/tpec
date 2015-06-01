<?php

/**
 * Class IngredientsController
 * Controlleur pour les ingrédients
 */
class IngredientsController extends BaseController {


    /**
     * Renvoie une vue de l'ensemble des conditionnements
     * @return \Illuminate\View\View Vue conditionnements.index
     */
    public function index()
	{
		$ingredients = Ingredient::orderBy('nom')->get();

		return View::make('ingredients.index', compact('ingredients'));
	}

    /**
     * Renvoie la vue pour créer un conditionnement
     * @return \Illuminate\View\View Vue conditionnements.create
     */
    public function create()
	{
		return View::make('ingredients.create');
	}

    /**
     * Méthode pour créer un conditionnement
     * @return \Illuminate\Http\RedirectResponse Redirection vers l'index des conditionnements
     */
    public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Ingredient::$rules);

		if ($validation->passes())
		{
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/ingredients';
                $filename = Str::slug(Input::get('nom')) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                // On stocke son nom en base:
                $input['image'] = $filename;
            } else {
                $input['image'] = '';
            }

			$ingredient = Ingredient::create(array_except($input, 'conditionnements'));

            // on chope tous les conditionnements et on prepare un array pret à être sync
            $conditionnements = Input::get('conditionnements');
            //dd($conditionnements);
            $conditionnementsTries = [];
            foreach ($conditionnements['id'] as $index => $conditionnementId) {
                $conditionnementsTries[$conditionnementId] = array(
                    'prix' => $conditionnements['prix'][$index]
                );
            }
            //on sync
            $ingredient->conditionnements()->sync($conditionnementsTries);


			return Redirect::route('ingredients.index');
		}
		return Redirect::route('ingredients.create')
			->withInput(Input::except('conditionnements'))->with('conditionnements', Input::get('conditionnements'))
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}


    /**
     * Vue d'un conditionnement
     * @param Conditionnement $conditionnement Instance d'un conditionnement
     * @return \Illuminate\View\View Vue conditionnements.show
     */
    public function show(Ingredient  $ingredient)
	{
		return View::make('ingredients.show', compact('ingredient'));
	}


    /**
     * Vue pour éditer un conditionnement
     * @param Ingredient $ingredient Instance d'un ingrédient
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Vue ingredients.edit
     */
    public function edit(Ingredient  $ingredient)
	{
		if (is_null($ingredient))
		{
			return Redirect::route('ingredients.index');
		}

		return View::make('ingredients.edit', compact('ingredient'));
	}


    /**
     * Mettre à jour un ingrédient
     * @param Ingredient $ingredient Instance d'un ingrédient
     * @return \Illuminate\Http\RedirectResponse Retourne la vue de l'ingrédient mis à jour, ou la vue pour éditer l'ingrédient en cas d'erreur
     */
    public function update(Ingredient  $ingredient)
	{
		$input = array_except(Input::all(), ['_method']);
        $rules = Ingredient::$rules;
        $rules['nom'] = 'required|unique:ingredients,nom,' . $ingredient->id;
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/ingredients';
                $filename = Str::slug(Input::get('nom')) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                // On stocke son nom en base:
                $input['image'] = $filename;
            } else {
                $input['image'] = $ingredient->image;
            }

            $ingredient->update(array_except($input, 'conditionnements'));

            // on chope tous les conditionnements et on prepare un array pret à être sync
            $conditionnements = Input::get('conditionnements');
            $conditionnementsTries = [];
            foreach ($conditionnements['id'] as $index => $conditionnementId) {
                $conditionnementsTries[$conditionnementId] = array(
                    'prix' => $conditionnements['prix'][$index]
                );
            }
            //on sync
            $ingredient->conditionnements()->sync($conditionnementsTries);


			return Redirect::route('ingredients.show', $ingredient->id);
		}

        dd($validation->errors());

		return Redirect::route('ingredients.edit', $ingredient->id)
			->withInput()
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}


    /**
     * Détruit l'ingrédient passé en parametre
     * @param Ingredient $ingredient Instance d'un ingrédient
     * @return \Illuminate\Http\RedirectResponse Renvoie vers ingredients.index
     * @throws Exception
     */
    public function destroy(Ingredient  $ingredient)
	{
		$ingredient->delete();

		return Redirect::route('ingredients.index');
	}

}
