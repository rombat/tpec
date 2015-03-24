@extends('layouts.scaffold')

@section('main')

<h1>Show Commentaire</h1>

<p>{{ link_to_route('commentaires.index', 'Return to All commentaires', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom</th>
				<th>Commentaire</th>
				<th>Note</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
