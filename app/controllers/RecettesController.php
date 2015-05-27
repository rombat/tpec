<?php

class RecettesController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$recettes = Recette::orderBy('nom')->get();

		return View::make('recettes.index', compact('recettes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('recettes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
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
			->withInput(Input::except(['ingredients']))
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Recette  $recette
	 * @return Response
	 */
	public function show(Recette  $recette)
	{
		return View::make('recettes.show', compact('recette'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Recette  $recette
	 * @return Response
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
	 * Update the specified resource in storage.
	 *
	 * @param  Recette  $recette
	 * @return Response
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
			->withInput()
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Recette  $recette)
	{
		$recette->delete();

		return Redirect::route('recettes.index');
	}

}
