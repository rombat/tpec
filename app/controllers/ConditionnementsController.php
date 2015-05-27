<?php

class ConditionnementsController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$conditionnements = Conditionnement::orderBy('nom')->get();

		return View::make('conditionnements.index', compact('conditionnements'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('conditionnements.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
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

	/**
	 * Display the specified resource.
	 *
	 * @param  Conditionnement  $conditionnement
	 * @return Response
	 */
	public function show(Conditionnement $conditionnement)
	{
		return View::make('conditionnements.show', compact('conditionnement'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Conditionnement  $conditionnement
	 * @return Response
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
	 * Update the specified resource in storage.
	 *
	 * @param  Conditionnement  $conditionnement
	 * @return Response
	 */
	public function update(Conditionnement $conditionnement)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Conditionnement::$rules);

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
	 * Remove the specified resource from storage.
	 *
	 * @param  Conditionnement  $conditionnement
	 * @return Response
	 */
	public function destroy(Conditionnement  $conditionnement)
	{
		$conditionnement->delete();

		return Redirect::route('conditionnements.index');
	}

}
