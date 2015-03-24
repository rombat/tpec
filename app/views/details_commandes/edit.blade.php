@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Details_commande</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($details_commande, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('details_commandes.update', $details_commande->id))) }}

        <div class="form-group">
            {{ Form::label('prix', 'Prix:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('prix', Input::old('prix'), array('class'=>'form-control', 'placeholder'=>'Prix')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('quantite', 'Quantite:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('quantite', Input::old('quantite'), array('class'=>'form-control', 'placeholder'=>'Quantite')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('details_commandes.show', 'Cancel', $details_commande->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop