@extends('template')

@section('title')
    Voir catégorie {{ $categorie->nom }}
@stop

@section('main')

    <h1>Catégorie:</h1>

    <p>{{ link_to_route('categories.index', 'Retourner vers toutes les categories', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <div class="container">
        <div class="row">
            <div class="pull-right" style="margin-top: 20px; margin-bottom: 10px;">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $categorie->id))) }}
                {{ Form::button('<i class="fa fa-times"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                <a href="{{ route('categories.edit', [$categorie->id]) }}" class="btn btn-info">
                    <i class="fa fa-pencil"></i></a>
            </div>
            <h2>@if($categorie->parent_id) {{ link_to_route('categories.show', $categorie->categorieParente->nom, [$categorie->categorieParente->id]) }}
                <i class="fa fa-angle-right"></i> @endif
                {{ $categorie->nom }}</h2>
        </div>

        <div class="col-sm-4">
            <img src="{{ asset('/images/categories/' . $categorie->image) }}" alt=""
                 class="img-responsive img-thumbnail"/>
        </div>
        <div class="col-sm-8">
            <h3>Description</h3>

            <p>{{ nl2br(e($categorie->description)) }}</p>
        </div>
    </div>
    <div class="row">
        <h3>Recettes</h3>

        @if($categorie->recettes->count() > 0)
            <ul>
                @foreach($categorie->recettes as $recette)
                    <li>{{ link_to_route('recettes.show', $recette->nom, [$recette->id]) }}</li>
                @endforeach
            </ul>
        @else
            <p>Pas de recette dans cette catégorie pour le moment</p>
        @endif

        @if($categorie->sousCategories->count() > 0 )
            <h3>Recettes des sous-catégories</h3>
            @foreach($categorie->sousCategories as $sousCat)
                @if($sousCat->recettes->count() > 0)
                    <h4>{{ link_to_route('categories.show', $sousCat->nom, [$sousCat->id]) }}</h4>
                    <ul>
                        @foreach($sousCat->recettes as $recette)
                            <li>{{ link_to_route('recettes.show', $recette->nom, [$recette->id]) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Pas de recette dans cette catégorie pour le moment</p>
                @endif
            @endforeach
        @endif
{{--
        <h2>Liste ingredients</h2>
        <ul>
            @foreach($categorie->ingredients() as $ingredient)
                <li>{{ $ingredient->nom }}</li>
            @endforeach
        </ul>--}}
    </div>

@stop
