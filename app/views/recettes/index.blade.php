@extends('layouts.scaffold')

@section('main')

<h1>All Recettes</h1>

<p>{{ link_to_route('recettes.create', 'Add New Recette', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($recettes->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Resume</th>
				<th>Description</th>
				<th>Temps_cuisson</th>
				<th>Temps_repos</th>
				<th>Difficulte</th>
				<th>Nombre_personnes</th>
				<th>Prix</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($recettes as $recette)
				<tr>
					<td>{{{ $recette->nom }}}</td>
					<td>{{{ $recette->resume }}}</td>
					<td>{{{ $recette->description }}}</td>
					<td>{{{ $recette->temps_cuisson }}}</td>
					<td>{{{ $recette->temps_repos }}}</td>
					<td>{{{ $recette->difficulte }}}</td>
					<td>{{{ $recette->nombre_personnes }}}</td>
					<td>{{{ $recette->prix }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('recettes.destroy', $recette->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('recettes.edit', 'Edit', array($recette->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no recettes
@endif

@stop
