<?php

class CommentairesController extends BaseController {

	/**
	 * Commentaire Repository
	 *
	 * @var Commentaire
	 */
	protected $commentaire;

	public function __construct(Commentaire $commentaire)
	{
		$this->commentaire = $commentaire;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commentaires = $this->commentaire->all();

		return View::make('commentaires.index', compact('commentaires'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('commentaires.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Commentaire::$rules);

		if ($validation->passes())
		{
			$this->commentaire->create($input);

			return Redirect::route('commentaires.index');
		}

		return Redirect::route('commentaires.create')
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
		$commentaire = $this->commentaire->findOrFail($id);

		return View::make('commentaires.show', compact('commentaire'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$commentaire = $this->commentaire->find($id);

		if (is_null($commentaire))
		{
			return Redirect::route('commentaires.index');
		}

		return View::make('commentaires.edit', compact('commentaire'));
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
		$validation = Validator::make($input, Commentaire::$rules);

		if ($validation->passes())
		{
			$commentaire = $this->commentaire->find($id);
			$commentaire->update($input);

			return Redirect::route('commentaires.show', $id);
		}

		return Redirect::route('commentaires.edit', $id)
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
		$this->commentaire->find($id)->delete();

		return Redirect::route('commentaires.index');
	}

}
