@extends('layouts.scaffold')

@section('main')

<h1>Show Details_commande</h1>

<p>{{ link_to_route('details_commandes.index', 'Return to All details_commandes', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Prix</th>
				<th>Quantite</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
