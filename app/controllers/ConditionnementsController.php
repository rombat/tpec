<?php

/**
 * Class ConditionnementsController
 * Controlleur pour les conditionnements
 */
class ConditionnementsController extends BaseController {


    /**
     * Renvoie une vue de l'ensemble des conditionnements
     * @return \Illuminate\View\View Vue conditionnements.index
     */
    public function index()
	{
		$conditionnements = Conditionnement::orderBy('nom')->get();

		return View::make('conditionnements.index', compact('conditionnements'));
	}

    /**
     * Renvoie la vue pour créer un conditionnement
     * @return \Illuminate\View\View Vue conditionnements.create
     */
    public function create()
	{
		return View::make('conditionnements.create');
	}


    /**
     * Méthode pour créer un conditionnement
     * @return \Illuminate\Http\RedirectResponse Redirection vers l'index des conditionnements
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse Renvoie les résultats de l'insert en json si la requete d'entrée est en ajax
     */
    public function store()
	{
        if(Request::ajax()) {
            $input = Input::all();
            $validation = Validator::make($input, Conditionnement::$rules);

            if ($validation->passes())
            {
                $cond = Conditionnement::create($input);
                $resultats = array(
                    'id' => $cond->id,
                    'nom' => $cond->nom
                );
                return Response::json($resultats, 200);
            }

            return Response::json(array(
                'success' => false,
                'errors' => $validation->getMessageBag()->toArray()
            ), 400);
        } else {
            $input = Input::all();
            $validation = Validator::make($input, Conditionnement::$rules);

            if ($validation->passes())
            {
                Conditionnement::create($input);

                return Redirect::route('conditionnements.index');
            }

            return Redirect::route('conditionnements.create')
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'Erreurs de validation.');
        }
	}


    /**
     * Vue d'un conditionnement
     * @param Conditionnement $conditionnement Instance d'un conditionnement
     * @return \Illuminate\View\View Vue conditionnements.show
     */
    public function show(Conditionnement $conditionnement)
	{
		return View::make('conditionnements.show', compact('conditionnement'));
	}


    /**
     * Vue pour éditer un conditionnement
     * @param Conditionnement $conditionnement Instance d'un conditionnement
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Vue conditionnements.edit
     */
    public function edit(Conditionnement $conditionnement)
	{
		if (is_null($conditionnement))
		{
			return Redirect::route('conditionnements.index');
		}

		return View::make('conditionnements.edit', compact('conditionnement'));
	}


    /**
     * Mettre à jour un conditionnement
     * @param Conditionnement $conditionnement
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Vue conditionnements.show si validé, sinon conditionnements.edit
     */
    public function update(Conditionnement $conditionnement)
	{
		$input = array_except(Input::all(), '_method');
        $rules = Conditionnement::$rules;
        $rules['nom'] = 'required|unique:conditionnements,nom,' . $conditionnement->nom;
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			$conditionnement->update($input);

			return Redirect::route('conditionnements.show', $conditionnement->id);
		}

		return Redirect::route('conditionnements.edit', $conditionnement->id)
			->withInput()
			->withErrors($validation)
			->with('message', 'Erreurs de validation.');
	}


    /**
     * Détruit le conditionnement passé en parametre
     * @param Conditionnement $conditionnement Instance du conditionnement
     * @return \Illuminate\Http\RedirectResponse Retourne vers l'index des conditionnements
     * @throws Exception
     */
    public function destroy(Conditionnement  $conditionnement)
	{
		$conditionnement->delete();

		return Redirect::route('conditionnements.index');
	}

}
