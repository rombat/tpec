@extends('layouts.scaffold')

@section('main')

<h1>All Images</h1>

<p>{{ link_to_route('images.create', 'Add New Image', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($images->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nom</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($images as $image)
				<tr>
					<td>{{{ $image->nom }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('images.destroy', $image->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('images.edit', 'Edit', array($image->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no images
@endif

@stop
