@extends('layouts.scaffold')

@section('main')

<h1>Show Image</h1>

<p>{{ link_to_route('images.index', 'Return to All images', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $image->nom }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('images.destroy', $image->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('images.edit', 'Edit', array($image->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
