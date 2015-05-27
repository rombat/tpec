@extends('template')

@section('title')
    Voir ingrédient {{ $ingredient->nom }}
@stop

@section('main')

    <h1>Voir Ingredient</h1>

    <p>{{ link_to_route('ingredients.index', 'Retourner vers tous les ingredients', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Actif</th>
            <th>Image</th>
            <th>Conditionnements</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>{{{ $ingredient->nom }}}</td>
            <td>{{{ $ingredient->description }}}</td>
            <td>{{{ $ingredient->active }}}</td>
            <td><img src="{{asset('/images/ingredients/' . $ingredient->image)}}" alt=""
                     class="img-responsive img-thumbnail" width="500"/></td>
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
                {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                <a href="{{ route('ingredients.edit', [$ingredient->id]) }}" class="btn btn-info">
                    <i class="glyphicon glyphicon-pencil"></i></a>
            </td>
        </tr>
        </tbody>
    </table>

@stop
