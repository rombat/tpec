<?php

class IngredientsController extends BaseController {

	/**
	 * Ingredient Repository
	 *
	 * @var Ingredient
	 */
	protected $ingredient;

	public function __construct(Ingredient $ingredient)
	{
		$this->ingredient = $ingredient;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ingredients = $this->ingredient->all();

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
			$this->ingredient->create($input);

			return Redirect::route('ingredients.index');
		}

		return Redirect::route('ingredients.create')
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
		$ingredient = $this->ingredient->findOrFail($id);

		return View::make('ingredients.show', compact('ingredient'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ingredient = $this->ingredient->find($id);

		if (is_null($ingredient))
		{
			return Redirect::route('ingredients.index');
		}

		return View::make('ingredients.edit', compact('ingredient'));
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
		$validation = Validator::make($input, Ingredient::$rules);

		if ($validation->passes())
		{
			$ingredient = $this->ingredient->find($id);
			$ingredient->update($input);

			return Redirect::route('ingredients.show', $id);
		}

		return Redirect::route('ingredients.edit', $id)
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
		$this->ingredient->find($id)->delete();

		return Redirect::route('ingredients.index');
	}

}
