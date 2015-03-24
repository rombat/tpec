<?php

class CommandesController extends BaseController {

	/**
	 * Commande Repository
	 *
	 * @var Commande
	 */
	protected $commande;

	public function __construct(Commande $commande)
	{
		$this->commande = $commande;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commandes = $this->commande->all();

		return View::make('commandes.index', compact('commandes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('commandes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Commande::$rules);

		if ($validation->passes())
		{
			$this->commande->create($input);

			return Redirect::route('commandes.index');
		}

		return Redirect::route('commandes.create')
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
		$commande = $this->commande->findOrFail($id);

		return View::make('commandes.show', compact('commande'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$commande = $this->commande->find($id);

		if (is_null($commande))
		{
			return Redirect::route('commandes.index');
		}

		return View::make('commandes.edit', compact('commande'));
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
		$validation = Validator::make($input, Commande::$rules);

		if ($validation->passes())
		{
			$commande = $this->commande->find($id);
			$commande->update($input);

			return Redirect::route('commandes.show', $id);
		}

		return Redirect::route('commandes.edit', $id)
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
		$this->commande->find($id)->delete();

		return Redirect::route('commandes.index');
	}

}
