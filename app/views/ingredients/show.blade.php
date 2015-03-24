@extends('layouts.scaffold')

@section('main')

<h1>Show Ingredient</h1>

<p>{{ link_to_route('ingredients.index', 'Return to All ingredients', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom</th>
				<th>Description</th>
				<th>Prix</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
