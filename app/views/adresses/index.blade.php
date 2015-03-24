@extends('layouts.scaffold')

@section('main')

<h1>All Adresses</h1>

<p>{{ link_to_route('adresses.create', 'Add New Adress', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($adresses->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Type</th>
				<th>Adresse</th>
				<th>Code_postal</th>
				<th>Ville</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($adresses as $adresse)
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
			@endforeach
		</tbody>
	</table>
@else
	There are no adresses
@endif

@stop
