@extends('template')

@section('title')
    Voir toutes les catégories
@stop

@section('main')

    <h1>Toutes les catégories</h1>

    <p>{{ link_to_route('categories.create', 'Ajouter Catégorie', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($categories->count())
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Active</th>
                <th>Image</th>
                {{--<th>Catégorie parente</th>--}}
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($categories as $categorie)
                <tr>
                    <td>
                        @if($categorie->parent_id) {{ link_to_route('categories.show', $categorie->categorieParente->nom, [$categorie->categorieParente->id]) }} <i class="fa fa-angle-double-right"></i> @endif {{ link_to_route('categories.show', $categorie->nom, [$categorie->id]) }}
                    </td>
                    <td>{{ substr($categorie->description, 0, 80) . '...' }}</td>
                    <td>@if($categorie->active) <i class="fa fa-check"></i>@else <i class="fa fa-times"></i>@endif</td>
                    <td><div class="image-reduite"><img src="{{ asset('/images/categories/' . $categorie->image) }}" alt="" width="100"/></div></td>
                    {{--<td>@if($categorie->parent_id) {{ $categorie->categorieParente->nom }} @else Aucune @endif</td>--}}
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $categorie->id))) }}
                        {{ Form::button('<i class="fa fa-times"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        <a href="{{ route('categories.edit', [$categorie->id]) }}" class="btn btn-info">
                            <i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        Pas de catégories
    @endif

@stop
