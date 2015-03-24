@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Create Recette</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'recettes.store', 'class' => 'form-horizontal')) }}

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
            {{ Form::label('temps_cuisson', 'Temps_cuisson:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('temps_cuisson', Input::old('temps_cuisson'), array('class'=>'form-control', 'placeholder'=>'Temps_cuisson')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('temps_repos', 'Temps_repos:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('temps_repos', Input::old('temps_repos'), array('class'=>'form-control', 'placeholder'=>'Temps_repos')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('difficulte', 'Difficulte:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('difficulte', Input::old('difficulte'), array('class'=>'form-control', 'placeholder'=>'Difficulte')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('nombre_personnes', 'Nombre_personnes:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('nombre_personnes', Input::old('nombre_personnes'), array('class'=>'form-control', 'placeholder'=>'Nombre_personnes')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('prix', 'Prix:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('prix', Input::old('prix'), array('class'=>'form-control', 'placeholder'=>'Prix')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Create', array('class' => 'btn btn-lg btn-primary')) }}
    </div>
</div>

{{ Form::close() }}

@stop


