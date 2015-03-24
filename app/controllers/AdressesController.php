<?php

class AdressesController extends BaseController {

	/**
	 * Adress Repository
	 *
	 * @var Adress
	 */
	protected $adresse;

	public function __construct(Adress $adresse)
	{
		$this->adresse = $adresse;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$adresses = $this->adresse->all();

		return View::make('adresses.index', compact('adresses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('adresses.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Adress::$rules);

		if ($validation->passes())
		{
			$this->adresse->create($input);

			return Redirect::route('adresses.index');
		}

		return Redirect::route('adresses.create')
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
		$adresse = $this->adresse->findOrFail($id);

		return View::make('adresses.show', compact('adresse'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$adresse = $this->adresse->find($id);

		if (is_null($adresse))
		{
			return Redirect::route('adresses.index');
		}

		return View::make('adresses.edit', compact('adresse'));
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
		$validation = Validator::make($input, Adress::$rules);

		if ($validation->passes())
		{
			$adresse = $this->adresse->find($id);
			$adresse->update($input);

			return Redirect::route('adresses.show', $id);
		}

		return Redirect::route('adresses.edit', $id)
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
		$this->adresse->find($id)->delete();

		return Redirect::route('adresses.index');
	}

}
