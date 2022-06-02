@extends("layouts.app")
@section("title","Modifier une collecte")
@section("content")
    @if(isset($sucess))
        @if($sucess == true)
            <div class="alert alert-success">
                Collecte modifiée avec succès
            </div>
        @endif
    @endif
    @if(isset($idCollecte))
        <?php
         $collecte = \App\collecteFixe::find($idCollecte);
        ?>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-3"><b>Collecte Fixe:</b></div>
            <div class="col-md-4" id="formulaire">
                <form action="/collecte/fixe/update/{{$collecte->id}}" method="post">
                    {{@csrf_field()}}
                    <label for="libCollecte">Libellé collecte</label><input class='form-control' type="text" id="libCollecte"  name="libCollecte" value="{{$collecte->libCollecte}}"><br>
                    <label for="dateCollecte">Date Collecte</label><input class='form-control' type="date" id="dateCollecte"  name="dateCollecte" value="{{$collecte->date}}" ><br>
                    <label for="centre">Centre</label>
                    <select name="idCentre" class="form-control">
                        @foreach(App\Centre::all() as $centre)
                            @if($collecte->centre->id == $centre->id)
                                <option value="{{$centre->id}}" selected>{{$centre->libCentre}}</option>
                            @else
                                <option value="{{$centre->id}}">{{$centre->libCentre}}</option>
                            @endif
                        @endforeach
                    </select><br>
                    <label for="nombre_presents">Nombre de présents :</label><input class='form-control' type="number" id="nombre_presents"  name="nombre_presents" value={{$collecte->nombre_presents}}><br>
                    <label for="nombre_contre_indiques">Nombre de contre-indiqués :</label><input class='form-control' type="number" id="nombre_contre_indiques"  name="nombre_contre_indiques" value={{$collecte->nombre_contre_indiques}}><br>
                    <button id="ajouterCollecte" class="btn btn-primary">Ajouter</button>
                    <button id="annuler" class="btn btn-primary">Annuler</button>
                </form>
            </div>
        </div>
    </div>
@endsection
