<div class="modal fade" id="ajoutConditionnementModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Ajouter un conditionnement</h4>
            </div>
            {{ Form::open(array('route' => 'conditionnements.store', 'class' => 'form-horizontal', 'id' => 'ajoutConditionnement')) }}
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('nom', 'Nom:', array('class'=>'col-md-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::text('nom', Input::old('cond_nom'), array('class'=>'form-control', 'placeholder'=>'Nom', 'id' => 'nom_cond')) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                {{ Form::button('Créer', array('class' => 'btn btn-lg btn-primary', 'id' => 'storeModal')) }}
            </div>
            {{ Form::close() }}
            <div class="alert alert-success alert-dismissible fade in hidden" id="cond_success">
                Le conditionnement a bien été ajouté!
            </div>
            <div class="alert alert-warning alert-dismissible fade in hidden" id="cond_errors">
                Erreurs
            </div>
        </div>
    </div>
</div>

