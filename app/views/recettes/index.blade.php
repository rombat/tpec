@extends('template')

@section('title')
    Voir toutes les recettes
@stop

@section('main')

<h1>Toutes les Recettes</h1>

<p>{{ link_to_route('recettes.create', 'Ajouter Recette', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($recettes->count())
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Resume</th>
				<th>Difficulte</th>
				<th>Pour</th>
				<th>Prix</th>
				<th>Active</th>
				<th>Image</th>
				<th>Categorie</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($recettes as $recette)
				<tr>
					<td>{{ link_to_route('recettes.show', $recette->nom, [$recette->id]) }}</td>
					<td>{{ substr($recette->resume,0, 50) . '...' }}</td>
					<td>@for($i = 1; $i <= $recette->difficulte; $i++)
                            <i class="fa fa-star"></i>
                        @endfor
                        @while($i <= 5)
                            <i class="fa fa-star-o"></i>
                            @php($i++)
                        @endwhile</td>
					<td>{{{ $recette->nb_personnes }}} @if($recette->nb_personnes != 1) personnes @else personne @endif</td>
					<td>{{ number_format($recette->prix, 2, ',', ' ') }} € {{--({{ number_format($recette->prixRevient(),2, ',', ' ') }} €)--}}</td>
					<td>@if($recette->active) <i class="fa fa-check"></i>@else <i class="fa fa-times"></i>@endif</td>
                    <td><div class="image-reduite"><img src="{{ asset('/images/recettes/' . $recette->image) }}" alt="" width="100"/></div></td>
					<td>{{ link_to_route('categories.show', $recette->categorie->nom, [$recette->categorie->id]) }}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('recettes.destroy', $recette->id))) }}
                            {{ Form::button('<i class="fa fa-times"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        <a href="{{ route('recettes.edit', [$recette->id]) }}" class="btn btn-info">
                            <i class="fa fa-pencil"></i></a>
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	Pas de recettes
@endif

@stop
