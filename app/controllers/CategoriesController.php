<?php

class CategoriesController extends BaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $categorie;

	public function __construct(Category $categorie)
	{
		$this->categorie = $categorie;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = $this->categorie->all();

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
		$validation = Validator::make($input, Category::$rules);

		if ($validation->passes())
		{
			$this->categorie->create($input);

			return Redirect::route('categories.index');
		}

		return Redirect::route('categories.create')
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
		$categorie = $this->categorie->findOrFail($id);

		return View::make('categories.show', compact('categorie'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$categorie = $this->categorie->find($id);

		if (is_null($categorie))
		{
			return Redirect::route('categories.index');
		}

		return View::make('categories.edit', compact('categorie'));
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
		$validation = Validator::make($input, Category::$rules);

		if ($validation->passes())
		{
			$categorie = $this->categorie->find($id);
			$categorie->update($input);

			return Redirect::route('categories.show', $id);
		}

		return Redirect::route('categories.edit', $id)
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
		$this->categorie->find($id)->delete();

		return Redirect::route('categories.index');
	}

}
