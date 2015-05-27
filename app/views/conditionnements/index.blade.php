@extends('template')

@section('title')
    Voir tous les conditionnements
@stop

@section('main')

    <h1>Tous les Conditionnements</h1>

    <p>{{ link_to_route('conditionnements.create', 'Ajouter Conditionnement', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($conditionnements->count())
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Existe pour</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($conditionnements as $conditionnement)
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
                        {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        <a href="{{ route('conditionnements.edit', [$conditionnement->id]) }}" class="btn btn-info">
                            <i class="glyphicon glyphicon-pencil"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        Pas de conditionnements
    @endif

@stop
