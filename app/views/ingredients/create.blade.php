@extends('template')

@section('title')
    Créer un ingrédient
@stop

@section('main')

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <h1>Créer Ingredient</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::open(array('route' => 'ingredients.store', 'class' => 'form-horizontal', 'files' => 'true')) }}

    <div class="form-group">
        {{ Form::label('nom', 'Nom:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nom', Input::old('nom'), array('class'=>'form-control', 'placeholder'=>'Nom')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('active', 'Actif:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::checkbox('active') }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('image', 'Image:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::file('image', Input::old('image'), array('class'=>'form-control', 'placeholder'=>'Image')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('conditionnements[]', 'Conditionnements:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10 conditionnements-group">
            <div class="row conditionnements-group-input">
                <div class="col-sm-6 margin-bottom-20">
                    <?php
                    $conditionnements = Conditionnement::all()->lists('nom', 'id');
                    ?>
                    {{ Form::select('conditionnements[id][]', $conditionnements, null) }}
                </div>
                <div class="input-group col-sm-6 margin-bottom-20">
                    {{ Form::number('conditionnements[prix][]', Input::old('prix'), array('class'=>'form-control', 'placeholder'=>'Prix', 'step' => '0.01')) }}
                    <div class="input-group-addon">€</div>
                </div>
            </div>
        </div>
        <div class="col-sm-offset-2 col-sm-10">
            <p>{{ Form::button('<i class="glyphicon glyphicon-plus"></i>', ['id' => 'ajoutIngredient']) }}
                {{ Form::button('<i class="glyphicon glyphicon-minus"></i>', ['id' => 'retraitIngredient']) }}</p>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ Form::submit('Créer', array('class' => 'btn btn-lg btn-primary')) }}
        </div>
    </div>

    {{ Form::close() }}

@stop

@section('scripts_additionnels')
    <script>
        var max_fields = 15; //maximum d'input permis
        var wrapper = $('.conditionnements-group'); //div encadrant
        var add_button = $("#ajoutIngredient"); //ajout de champs
        var del_button = $('#retraitIngredient');
        var input_group = $('.conditionnements-group-input')[0].outerHTML;

        var x = 1; // Compteur d'ajouts
        $(add_button).click(function (e) { // Event au click du bouton d'ajout
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append(input_group); //ajout d'un bloc d'input
            }
        });

        $(del_button).click(function (e) { //retrait d'un bloc d'input et du dernier index des tableaux d'input
            e.preventDefault();
            if (x > 1) {
                $('.conditionnements-group-input').last().remove();
                x--;
            }
        });
    </script>
@stop

