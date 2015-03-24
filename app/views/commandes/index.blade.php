@extends('layouts.scaffold')

@section('main')

<h1>All Commandes</h1>

<p>{{ link_to_route('commandes.create', 'Add New Commande', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($commandes->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Total</th>
				<th>Statut</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($commandes as $commande)
				<tr>
					<td>{{{ $commande->total }}}</td>
					<td>{{{ $commande->statut }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('commandes.destroy', $commande->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('commandes.edit', 'Edit', array($commande->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no commandes
@endif

@stop
