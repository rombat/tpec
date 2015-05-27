@extends('template')

@section('title')
    Voir recette {{ $recette->nom }}
@stop

@section('main')

<h1>Voir Recette</h1>

<p>{{ link_to_route('recettes.index', 'Retourner vers toutes les recettes', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<div class="container">
    <div class="row">
        <div class="pull-right" style="margin-top: 20px; margin-bottom: 10px;">
            {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('recettes.destroy', $recette->id))) }}
            {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
            {{ Form::close() }}
            <a href="{{ route('recettes.edit', [$recette->id]) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i></a>
        </div>
        <h2>@if($recette->categorie->parent_id) {{ link_to_route('categories.show', $recette->categorie->categorieParente->nom, [$recette->categorie->categorieParente->id]) }} <i class="fa fa-angle-right"></i> @endif
            {{ link_to_route('categories.show', $recette->categorie->nom, [$recette->categorie->id]) }} <i class="fa fa-angle-right"></i> {{ $recette->nom }}</h2>
    </div>



    <div class="col-sm-4">
        <img src="{{ asset('/images/recettes/' . $recette->image) }}" alt="" class="img-responsive img-thumbnail"/>
    </div>
    <div class="col-sm-3">
        <h3>Caractéristiques</h3>
        <p><strong>Difficulté:</strong>
            <span class="pull-right">@for($i = 1; $i <= $recette->difficulte; $i++)
                <i class="fa fa-star"></i>
            @endfor
            @while($i <= 5)
                <i class="fa fa-star-o"></i>
                @php($i++)
            @endwhile</span>
        </p>

        <p><strong>Temps de préparation:</strong> <span class="pull-right">{{ $recette->temps_preparation }}</span></p>

        @if($recette->temps_cuisson)<p><strong>Temps de cuisson:</strong> <span class="pull-right">{{ $recette->temps_cuisson }}</span></p>@endif

        <p><strong>Recette pour:</strong> <span class="pull-right">{{ $recette->nb_personnes }} @if($recette->nb_personnes > 1) personnes @else personne @endif</span></p>

        <p><strong>Prix:</strong><span class="pull-right">{{ number_format($recette->prix, 2, ',', ' ') }} €</span></p>

        <p><strong>Recette active sur le site:</strong><span class="pull-right">@if($recette->active) <i class="fa fa-check"></i>@else <i class="fa fa-times"></i>@endif</span></p>
    </div>

    <div class="col-sm-5">
        <h3>Ingrédients</h3>
        <ul>
            @foreach($recette->ingredients as $ingredient)
            <li>{{ $ingredient->pivot->quantite }} {{ $ingredient->pivot->unite }} de {{ link_to_route('ingredients.show', strtolower($ingredient->nom), [$ingredient->id]) }}</li>
            @endforeach
        </ul>

    </div>

</div>

    <div class="container">
        <h3>Résumé:</h3>
        <p>{{ $recette->resume }}</p>
        <h3>Description complète:</h3>
        <p>{{ $recette->description }}</p>
    </div>

@stop
