<?php

/**
 * Class RecettesController
 * Controlleur pour les recettes
 */
class RecettesController extends BaseController {


    /** Index des recettes
     * @return \Illuminate\View\View Vue recettes.index
     */
    public function index()
	{
		$recettes = Recette::orderBy('nom')->get();

		return View::make('recettes.index', compact('recettes'));
	}


    /**Création d'une recette
     * @return \Illuminate\View\View Vue recettes.create
     */
    public function create()
	{
		return View::make('recettes.create');
	}


    /**
     * Créer une recette
     * @return \Illuminate\Http\RedirectResponse Vue recettes.index si validé, sinon recettes.create avec erreurs
     */
    public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Recette::$rules);

		if ($validation->passes())
		{
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/recettes';
                $filename = Str::slug(Input::get('nom')) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                // On stocke son nom en base:
                $input['image'] = $filename;
            } else {
                $input['image'] = '';
            }
            // on sauve la recette, sans les ingredients (table pivot, a sync a part)
			$recette = Recette::create(array_except($input, 'ingredients'));
            // on chope tous les ingredients et on prepare un array pret à être sync
            $ingredients = Input::get('ingredients');
            $ingredientsTries = [];
            foreach ($ingredients['id'] as $index => $ingredientId) {
                $ingredientsTries[$ingredientId] = array(
                    'quantite' => $ingredients['quantite'][$index],
                    'unite' => $ingredients['unite'][$index]
                );
            }
            //on sync
            $recette->ingredients()->sync($ingredientsTries);

            return Redirect::route('recettes.index');
		}
        //dd($validation);
		return Redirect::route('recettes.create')
			->withInput(Input::except(['ingredients']))->with('ingredients', Input::get('ingredients'))
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}


    /**
     * Voir une recette
     * @param Recette $recette Instance d'une recette
     * @return \Illuminate\View\View Vue recettes.show
     */
    public function show(Recette  $recette)
	{
		return View::make('recettes.show', compact('recette'));
	}


    /**
     * Editer une recette
     * @param Recette $recette Instance d'une recette
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Vue recettes.edit
     */
    public function edit(Recette  $recette)
	{
		if (is_null($recette))
		{
			return Redirect::route('recettes.index');
		}

		return View::make('recettes.edit', compact('recette'));
	}


    /**
     * Mettre à jour une recette
     * @param Recette $recette Instance d'une recette
     * @return \Illuminate\Http\RedirectResponse Vue recettes.show si validé, sinon recettes.edit
     */
    public function update(Recette  $recette)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Recette::$rules);

		if ($validation->passes())
		{
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/recettes';
                $filename = Str::slug(Input::get('nom')) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                // On stocke son nom en base:
                $input['image'] = $filename;
            } else {
                $input['image'] = $recette->image;
            }

			$recette->update(array_except($input, 'ingredients'));

            // on chope tous les ingredients et on prepare un array pret à être sync
            $ingredients = Input::get('ingredients');
            $ingredientsTries = [];
            foreach ($ingredients['id'] as $index => $ingredientId) {
                $ingredientsTries[$ingredientId] = array(
                    'quantite' => $ingredients['quantite'][$index],
                    'unite' => $ingredients['unite'][$index]
                );
            }
            //on sync
            $recette->ingredients()->sync($ingredientsTries);


			return Redirect::route('recettes.show', $recette->id);
		}

		return Redirect::route('recettes.edit', $recette->id)
			->withInput(Input::except('ingredients'))->with('ingredients', Input::get('ingredients'))
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}


    /**
     * Détruire une recette
     * @param Recette $recette Instance d'une recette
     * @return \Illuminate\Http\RedirectResponse Vue recettes.index
     * @throws Exception
     */
    public function destroy(Recette  $recette)
	{
		$recette->delete();

		return Redirect::route('recettes.index');
	}

}
