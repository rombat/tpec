@extends('template')

@section('title')
    Voir catégorie {{ $categorie->nom }}
@stop

@section('main')

    <h1>Voir Catégorie</h1>

    <p>{{ link_to_route('categories.index', 'Retourner vers toutes les categories', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

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
        <tr>
            <td>{{{ $categorie->nom }}}</td>
            <td>{{ nl2br(e($categorie->description)) }}</td>
            <td>@if($categorie->active) <i class="fa fa-check"></i>@else <i class="fa fa-times"></i>@endif</td>
            <td><img src="{{asset('/images/categories/' . $categorie->image)}}" alt=""
                     class="img-responsive img-thumbnail" width="400"/></td>
            <td>@if($categorie->parent_id) {{ $categorie->categorieParente->nom }} @else Aucune @endif</td>
            <td>
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $categorie->id))) }}
                {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                <a href="{{ route('categories.edit', [$categorie->id]) }}" class="btn btn-info">
                    <i class="glyphicon glyphicon-pencil"></i></a>
            </td>
        </tr>
        </tbody>
    </table>

@stop
