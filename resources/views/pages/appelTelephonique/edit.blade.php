@extends("layouts.app")
@section("title","")
@section("content")
@if(isset($id))
    <?php
            $appel = \App\appelTelephonique::find($id);
    ?>
    <div class="container-fluid">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="/appelTelephonique/update/{{$appel->id}}" method="post">
                {{csrf_field()}}
                <label for="tele">Téléphone</label>
                <input type="text" name="tele" class="form-control" value="{{$appel->tele}}" placeholder="Téléphone" id="tele"><br>
                <label for="nom">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{$appel->nom}}" placeholder="Nom" id="nom"><br>
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" class="form-control" value="{{$appel->prenom}}" placeholder="Prenom" id="prenom"><br>
                <label for="reponse">Réponse</label>
                <select class="form-control" id="reponse" name="reponse">
                    <option value="1">Favorable</option>
                    <option value="2">Défavorable</option>
                    <option value="3">Pas de réponse</option>
                    <option value="4">A rappeler</option>
                </select><br>
                <input type="hidden" value="{{auth()->user()->id}}" name="benevole">
                <input type="submit" class="btn btn-primary" value="Enregistrer">
                <input type="reset" class="btn btn-danger" value="Annuler">
            </form>
        </div>
    </div>

@endif
@endsection