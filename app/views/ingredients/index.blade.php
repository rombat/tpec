@extends('layouts.scaffold')

@section('main')

<h1>All Ingredients</h1>

<p>{{ link_to_route('ingredients.create', 'Add New Ingredient', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($ingredients->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Prix</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($ingredients as $ingredient)
				<tr>
					<td>{{{ $ingredient->nom }}}</td>
					<td>{{{ $ingredient->description }}}</td>
					<td>{{{ $ingredient->prix }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ingredients.destroy', $ingredient->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('ingredients.edit', 'Edit', array($ingredient->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no ingredients
@endif

@stop
