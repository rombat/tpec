@extends('template')

@section('title')
    Voir toutes les catégories
@stop

@section('main')

    <h1>Toutes les catégories</h1>

    <p>{{ link_to_route('categories.create', 'Ajouter Catégorie', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($categories->count())
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Active</th>
                <th>Image</th>
                <th>Catégorie parente</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($categories as $categorie)
                <tr>
                    <td>
                        <a href="{{ route('categories.show', [$categorie->id]) }}" {{--class="btn btn-primary"--}}>{{{ $categorie->nom }}}</a>
                    </td>
                    <td>{{{ $categorie->description }}}</td>
                    <td>{{{ $categorie->active }}}</td>
                    <td><img src="{{ asset('/images/categories/' . $categorie->image) }}" alt="" width="80"/></td>
                    <td>@if($categorie->parent_id) {{ $categorie->categorieParente->nom }} @else Aucune @endif</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $categorie->id))) }}
                        {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        <a href="{{ route('categories.edit', [$categorie->id]) }}" class="btn btn-info">
                            <i class="glyphicon glyphicon-pencil"></i></a>
                    </td>
                </tr>
                @foreach($categorie->sousCategories as $souscategorie)
                    <tr class="warning">
                        <td>
                            {{ link_to_route('categories.show', $categorie->nom, [$categorie->id]) }} >> {{ link_to_route('categories.show', $souscategorie->nom, [$souscategorie->id]) }}
                        </td>
                        <td>{{{ $souscategorie->description }}}</td>
                        <td>{{{ $souscategorie->active }}}</td>
                        <td><img src="{{ asset('/images/categories/' . $souscategorie->image) }}" alt="" width="80"/></td>
                        <td>{{ $souscategorie->categorieParente->nom }}</td>
                        <td>
                            {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $souscategorie->id))) }}
                            {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                            <a href="{{ route('categories.edit', [$souscategorie->id]) }}" class="btn btn-info">
                                <i class="glyphicon glyphicon-pencil"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    @else
        Pas de catégories
    @endif

@stop
