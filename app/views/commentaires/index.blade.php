@extends('layouts.scaffold')

@section('main')

<h1>All Commentaires</h1>

<p>{{ link_to_route('commentaires.create', 'Add New Commentaire', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($commentaires->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Commentaire</th>
				<th>Note</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($commentaires as $commentaire)
				<tr>
					<td>{{{ $commentaire->nom }}}</td>
					<td>{{{ $commentaire->commentaire }}}</td>
					<td>{{{ $commentaire->note }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('commentaires.destroy', $commentaire->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('commentaires.edit', 'Edit', array($commentaire->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no commentaires
@endif

@stop
