@extends('template')

@section('title')
    Voir contitionnement {{ $conditionnement->nom }}
@stop

@section('main')

    <h1>Voir Conditionnement</h1>

    <p>{{ link_to_route('conditionnements.index', 'Retourner vers tous les conditionnements', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Existe pour</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>{{{ $conditionnement->nom }}}</td>
            <td>
                @if(!$conditionnement->ingredients)
                    Aucun ingrédient
                @else
                    @foreach($conditionnement->ingredients as $ingredient)
                        {{ link_to_route('ingredients.show', $ingredient->nom, [$ingredient->id]) }} <br/>
                    @endforeach
                @endif
            </td>
            <td>
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('conditionnements.destroy', $conditionnement->id))) }}
                {{ Form::button('<i class="fa fa-times"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                <a href="{{ route('conditionnements.edit', [$conditionnement->id]) }}" class="btn btn-info">
                    <i class="fa fa-pencil"></i></a
            </td>
        </tr>
        </tbody>
    </table>

@stop
