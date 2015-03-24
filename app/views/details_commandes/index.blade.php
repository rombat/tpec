@extends('layouts.scaffold')

@section('main')

<h1>All Details_commandes</h1>

<p>{{ link_to_route('details_commandes.create', 'Add New Details_commande', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($details_commandes->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Prix</th>
				<th>Quantite</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($details_commandes as $details_commande)
				<tr>
					<td>{{{ $details_commande->prix }}}</td>
					<td>{{{ $details_commande->quantite }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('details_commandes.destroy', $details_commande->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('details_commandes.edit', 'Edit', array($details_commande->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no details_commandes
@endif

@stop
