@extends('template')

@section('title')
    Editer catégorie {{ $categorie->nom }}
@stop


@section('main')

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <h1>Editer Catégorie</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::model($categorie, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('categories.update', $categorie->id), 'files' => true)) }}

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
        {{ Form::label('active', 'Active:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::checkbox('active') }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('image', 'Image:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::file('image', Input::old('image'), array('class'=>'form-control', 'placeholder'=>'Image')) }}
            @if($categorie->image)
                <br/>
                <img src="{{asset('/images/categories/' . $categorie->image)}}" alt="{{ $categorie->nom }}"
                     class="img-responsive img-thumbnail" width="400"/>
            @endif
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('parent_id', 'Catégorie parente:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            <?php
            $categories = Categorie::all(['id', 'nom'])->diff([$categorie])->lists('nom', 'id');
            $categories[''] = 'Aucune';
            ?>
            {{ Form::select('parent_id', $categories) }}
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ Form::submit('Mettre à jour', array('class' => 'btn btn-lg btn-primary')) }}
            {{ link_to_route('categories.show', 'Annuler', $categorie->id, array('class' => 'btn btn-lg btn-default')) }}
        </div>
    </div>

    {{ Form::close() }}

@stop