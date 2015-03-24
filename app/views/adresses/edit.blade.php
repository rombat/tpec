@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Adress</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($adresse, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('adresses.update', $adresse->id))) }}

        <div class="form-group">
            {{ Form::label('type', 'Type:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('type', Input::old('type'), array('class'=>'form-control', 'placeholder'=>'Type')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('adresse', 'Adresse:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('adresse', Input::old('adresse'), array('class'=>'form-control', 'placeholder'=>'Adresse')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('code_postal', 'Code_postal:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('code_postal', Input::old('code_postal'), array('class'=>'form-control', 'placeholder'=>'Code_postal')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('ville', 'Ville:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('ville', Input::old('ville'), array('class'=>'form-control', 'placeholder'=>'Ville')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('adresses.show', 'Cancel', $adresse->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop