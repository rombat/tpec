@extends('template')

@section('title')
    Voir tous les ingrédients
@stop

@section('main')

<h1>Tous les Ingredients</h1>

<p>{{ link_to_route('ingredients.create', 'Ajouter Ingredient', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($ingredients->count())
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actif</th>
				<th>Image</th>
				<th>Conditionnements</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($ingredients as $ingredient)
				<tr>
					<td>{{ link_to_route('ingredients.show', $ingredient->nom, [$ingredient->id]) }}</td>
					<td>{{{ substr($ingredient->description, 0, 80) . '...' }}}</td>
					<td>@if($ingredient->active) <i class="fa fa-check"></i>@else <i class="fa fa-times"></i>@endif</td>
                    <td><div class="image-reduite"><img src="{{ asset('/images/ingredients/' . $ingredient->image) }}" alt="" width="100"/></div></td>
                    <td>@if(!$ingredient->conditionnements)
                        Aucun
                    @else
                        @foreach($ingredient->conditionnements as $conditionnement)
                            {{ link_to_route('conditionnements.show', $conditionnement->nom, [$conditionnement->id]) }} ({{ number_format($conditionnement->pivot->prix, 2, ',', ' ') }}€)
                                <br/>
                        @endforeach
                    @endif
                        </td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ingredients.destroy', $ingredient->id))) }}
                        {{ Form::button('<i class="fa fa-times"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        <a href="{{ route('ingredients.edit', [$ingredient->id]) }}" class="btn btn-info">
                            <i class="fa fa-pencil"></i></a>
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	Pas d'ingredients
@endif

@stop
