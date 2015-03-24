@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Commande</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($commande, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('commandes.update', $commande->id))) }}

        <div class="form-group">
            {{ Form::label('total', 'Total:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('total', Input::old('total'), array('class'=>'form-control', 'placeholder'=>'Total')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('statut', 'Statut:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('statut', Input::old('statut'), array('class'=>'form-control', 'placeholder'=>'Statut')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('commandes.show', 'Cancel', $commande->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop