<?php

/**
 * Class CategoriesController
 * Controller pour les catégories
 */
class CategoriesController extends BaseController {


    /**
     * Renvoie une vue de l'ensemble des catégories
     * @return \Illuminate\View\View Vue categories.index
     */
    public function index()
	{
		$categories = Categorie::orderBy('parent_id')->get();

		return View::make('categories.index', compact('categories'));
	}


    /**
     * Renvoie la vue pour créer une catégorie
     * @return \Illuminate\View\View Vue categories.create
     */
    public function create()
	{
		return View::make('categories.create');
	}


    /**
     * Méthode pour créer une catégorie
     * @return \Illuminate\Http\RedirectResponse Redirection vers l'index des catégories
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
     * Vue d'une catégorie
     * @param Categorie $categorie Instance d'une catégorie
     * @return \Illuminate\View\View Vue categories.show
     */
    public function show(Categorie $categorie)
	{
		return View::make('categories.show', compact('categorie'));
	}


    /**
     * Vue pour éditer une catégorie
     * @param Categorie $categorie Instance d'une catégorie
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Vue categories.edit
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
     * Mettre à jour une catégorie
     * @param Categorie $categorie Instance d'une catégorie
     * @return \Illuminate\Http\RedirectResponse Retourne la vue de la catégorie mise à jour, ou la vue pour éditer la catégorie en cas d'erreur
     */
    public function update(Categorie $categorie)
	{
		$input = array_except(Input::all(), '_method');
        $rules = Categorie::$rules;
        $rules['nom'] = 'required|unique:categories,nom,' . $categorie->nom;
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
     * Détruit la catégorie passée en parametre
     * @param Categorie $categorie Instance de la catégori
     * @return \Illuminate\Http\RedirectResponse Retourne vers l'index des catégories
     * @throws Exception
     */
    public function destroy(Categorie $categorie)
	{
		$categorie->delete();

		return Redirect::route('categories.index');
	}

}
