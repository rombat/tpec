<?php

class CategoriesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = Categorie::whereNull('parent_id')->get();

		return View::make('categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
        //dd($input);
		$validation = Validator::make($input, Categorie::$rules);

		if ($validation->passes())
		{
            if(Input::get('parent_id') == null) {
                $input['parent_id'] = null;
            }
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/categories';
                $filename = Str::slug(Input::get('nom')) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                // On stocke son nom en base:
                $input['image'] = $filename;
            } else {
                $input['image'] = '';
            }
			Categorie::create($input);

			return Redirect::route('categories.index');
		}

		return Redirect::route('categories.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Categorie $categorie
	 * @return Response
	 */
	public function show(Categorie $categorie)
	{
		return View::make('categories.show', compact('categorie'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Categorie $categorie)
	{
		if (is_null($categorie))
		{
			return Redirect::route('categories.index');
		}

		return View::make('categories.edit', compact('categorie', 'categories'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Categorie $categorie
	 * @return Response
	 */
	public function update(Categorie $categorie)
	{
		$input = array_except(Input::all(), '_method');

		$validation = Validator::make($input, Categorie::$rules);

		if ($validation->passes())
		{
            if(Input::get('parent_id') == '') {
                $input['parent_id'] = null;
            }
            if(Input::hasFile('image')) {
                // On uploade l'image
                $image = Input::file('image');
                $destinationPath = public_path() . '/images/categories';
                $filename = Str::slug(Input::get('nom')) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                // On stocke son nom en base:
                $input['image'] = $filename;
            } else {
                $input['image'] = $categorie->image;
            }

			$categorie->update($input);

			return Redirect::route('categories.show', $categorie->id);
		}

		return Redirect::route('categories.edit', $categorie->id)
			->withInput(Input::except('image'))
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Categorie $categorie
	 * @return Response
	 */
	public function destroy(Categorie $categorie)
	{
		$categorie->delete();

		return Redirect::route('categories.index');
	}

}
