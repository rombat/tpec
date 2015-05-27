<?php

class IngredientsController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ingredients = Ingredient::orderBy('nom')->get();

		return View::make('ingredients.index', compact('ingredients'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('ingredients.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
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
			->withInput()
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Ingredient  $ingredient
	 * @return Response
	 */
	public function show(Ingredient  $ingredient)
	{
		return View::make('ingredients.show', compact('ingredient'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Ingredient  $ingredient
	 * @return Response
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
	 * Update the specified resource in storage.
	 *
	 * @param  Ingredient  $ingredient
	 * @return Response
	 */
	public function update(Ingredient  $ingredient)
	{
		$input = array_except(Input::all(), ['_method']);
		$validation = Validator::make($input, Ingredient::$rules);

		if ($validation->passes())
		{
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/categories';
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

		return Redirect::route('ingredients.edit', $ingredient->id)
			->withInput()
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Ingredient  $ingredient
	 * @return Response
	 */
	public function destroy(Ingredient  $ingredient)
	{
		$ingredient->delete();

		return Redirect::route('ingredients.index');
	}

}
