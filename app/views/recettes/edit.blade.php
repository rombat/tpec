@extends('template')

@section('title')
    Editer recette {{ $recette->nom }}
@stop

@section('main')

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <h1>Editer Recette</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::model($recette, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('recettes.update', $recette->id), 'files' => 'true')) }}

    <div class="form-group">
        {{ Form::label('nom', 'Nom:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nom', Input::old('nom'), array('class'=>'form-control', 'placeholder'=>'Nom')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('resume', 'Resume:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('resume', Input::old('resume'), array('class'=>'form-control', 'placeholder'=>'Resume')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('temps_preparation', 'Temps de preparation:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('temps_preparation', Input::old('temps_preparation'), array('class'=>'form-control', 'placeholder'=>'hh:mm:ss')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('temps_cuisson', 'Temps de cuisson:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('temps_cuisson', Input::old('temps_cuisson'), array('class'=>'form-control', 'placeholder'=>'hh:mm:ss')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('difficulte', 'Difficulte:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            <?php
            $difficulte = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'];
            ?>
            {{ Form::select('difficulte', $difficulte, $recette->difficulte, array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('nb_personnes', 'Nombre de personnes:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::number('nb_personnes', Input::old('nb_personnes'), array('class'=>'form-control', 'placeholder'=>'Nb_personnes')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('prix', 'Prix:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            <div class="input-group">
                {{ Form::number('prix', Input::old('prix'), array('class'=>'form-control', 'placeholder'=>'Prix', 'step' => '0.01')) }}
                <div class="input-group-addon">€</div>
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('active', 'Active:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::checkbox('active') }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('image', 'Image:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::file('image', null, array('class'=>'form-control', 'placeholder'=>'Image')) }}
            @if($recette->image)
                <img src="{{asset('/images/recettes/' . $recette->image)}}" alt="{{ $recette->nom }}"
                     class="img-responsive img-thumbnail" width="400"/>
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('categorie_id', 'Categorie:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            <?php
            $categories = Categorie::all(['id', 'nom'])->lists('nom', 'id');
            ?>
            {{ Form::select('categorie_id', $categories, $recette->categorie_id) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('ingredients', 'Ingredients:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10 ingredients-group">
            @foreach($recette->ingredients as $ingredient)
                <div class="ingredients-group-input">
                    <div class="col-sm-4 padding-input-inline-fix margin-bottom-20">
                        {{ Form::number('ingredients[quantite][]', $ingredient->pivot->quantite, ['placeholder' => 'Quantite'])}}
                    </div>
                    <div class="col-sm-4 margin-bottom-20">
                        {{ Form::text('ingredients[unite][]', $ingredient->pivot->unite, ['placeholder' => 'Unité', 'list' => 'unites']) }}
                        <datalist id="unites">

                            @foreach(Ingredient::unitesDispos() as $unite)
                                <option value="{{ $unite->unite }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-sm-4 margin-bottom-20">
                        <?php
                        $ingredients = Ingredient::all(['id', 'nom'])->lists('nom', 'id');
                        ?>
                        {{ Form::select('ingredients[id][]', $ingredients, $ingredient->id) }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-sm-offset-2 col-sm-10">
            <p>{{ Form::button('<i class="glyphicon glyphicon-plus"></i>', ['id' => 'ajoutIngredient']) }}
                {{ Form::button('<i class="glyphicon glyphicon-minus"></i>', ['id' => 'retraitIngredient']) }}</p>
        </div>


        <br/>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ Form::submit('Mettre à jour', array('class' => 'btn btn-lg btn-primary')) }}
            {{ link_to_route('recettes.show', 'Annuler', $recette->id, array('class' => 'btn btn-lg btn-default')) }}
        </div>
    </div>

    {{ Form::close() }}

@stop

@section('scripts_additionnels')
    <script>
        var max_fields = 15; //maximum d'input permis
        var wrapper = $('.ingredients-group'); //div encadrant
        var add_button = $("#ajoutIngredient"); //ajout de champs
        var del_button = $('#retraitIngredient');
        var input_group = $('.ingredients-group-input')[0].outerHTML;

        var x = {{ $recette->ingredients()->count();  }}; // Compteur d'ajouts
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
                $('.ingredients-group-input').last().remove();
                x--;
            }
        });
    </script>
@stop