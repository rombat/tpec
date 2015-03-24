@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Commentaire</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($commentaire, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('commentaires.update', $commentaire->id))) }}

        <div class="form-group">
            {{ Form::label('nom', 'Nom:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('nom', Input::old('nom'), array('class'=>'form-control', 'placeholder'=>'Nom')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('commentaire', 'Commentaire:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::textarea('commentaire', Input::old('commentaire'), array('class'=>'form-control', 'placeholder'=>'Commentaire')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('note', 'Note:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('note', Input::old('note'), array('class'=>'form-control', 'placeholder'=>'Note')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('commentaires.show', 'Cancel', $commentaire->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop