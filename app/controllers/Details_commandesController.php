<?php

class Details_commandesController extends BaseController {

	/**
	 * Details_commande Repository
	 *
	 * @var Details_commande
	 */
	protected $details_commande;

	public function __construct(Details_commande $details_commande)
	{
		$this->details_commande = $details_commande;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$details_commandes = $this->details_commande->all();

		return View::make('details_commandes.index', compact('details_commandes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('details_commandes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Details_commande::$rules);

		if ($validation->passes())
		{
			$this->details_commande->create($input);

			return Redirect::route('details_commandes.index');
		}

		return Redirect::route('details_commandes.create')
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
		$details_commande = $this->details_commande->findOrFail($id);

		return View::make('details_commandes.show', compact('details_commande'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$details_commande = $this->details_commande->find($id);

		if (is_null($details_commande))
		{
			return Redirect::route('details_commandes.index');
		}

		return View::make('details_commandes.edit', compact('details_commande'));
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
		$validation = Validator::make($input, Details_commande::$rules);

		if ($validation->passes())
		{
			$details_commande = $this->details_commande->find($id);
			$details_commande->update($input);

			return Redirect::route('details_commandes.show', $id);
		}

		return Redirect::route('details_commandes.edit', $id)
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
		$this->details_commande->find($id)->delete();

		return Redirect::route('details_commandes.index');
	}

}
