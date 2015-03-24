@extends('layouts.scaffold')

@section('main')

<h1>Show Adress</h1>

<p>{{ link_to_route('adresses.index', 'Return to All adresses', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Type</th>
				<th>Adresse</th>
				<th>Code_postal</th>
				<th>Ville</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $adresse->type }}}</td>
					<td>{{{ $adresse->adresse }}}</td>
					<td>{{{ $adresse->code_postal }}}</td>
					<td>{{{ $adresse->ville }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('adresses.destroy', $adresse->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('adresses.edit', 'Edit', array($adresse->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
