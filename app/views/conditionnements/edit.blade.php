@extends('template')

@section('title')
    Editer conditionnement {{ $conditionnement->nom }}
@stop


@section('main')

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <h1>Editer Conditionnement</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::model($conditionnement, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('conditionnements.update', $conditionnement->id))) }}

    <div class="form-group">
        {{ Form::label('nom', 'Nom:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nom', Input::old('nom'), array('class'=>'form-control', 'placeholder'=>'Nom')) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ Form::submit('Mettre à jour', array('class' => 'btn btn-lg btn-primary')) }}
            {{ link_to_route('conditionnements.show', 'Annuler', $conditionnement->id, array('class' => 'btn btn-lg btn-default')) }}
        </div>
    </div>

    {{ Form::close() }}

@stop