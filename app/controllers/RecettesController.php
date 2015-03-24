<?php

class RecettesController extends BaseController {

	/**
	 * Recette Repository
	 *
	 * @var Recette
	 */
	protected $recette;

	public function __construct(Recette $recette)
	{
		$this->recette = $recette;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$recettes = $this->recette->all();

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
			$this->recette->create($input);

			return Redirect::route('recettes.index');
		}

		return Redirect::route('recettes.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$recette = $this->recette->findOrFail($id);

		return View::make('recettes.show', compact('recette'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$recette = $this->recette->find($id);

		if (is_null($recette))
		{
			return Redirect::route('recettes.index');
		}

		return View::make('recettes.edit', compact('recette'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Recette::$rules);

		if ($validation->passes())
		{
			$recette = $this->recette->find($id);
			$recette->update($input);

			return Redirect::route('recettes.show', $id);
		}

		return Redirect::route('recettes.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->recette->find($id)->delete();

		return Redirect::route('recettes.index');
	}

}
