@extends("layouts.app")
@section("title", "Nouvelle dépense")
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-4">
                <form action="/depense/store" method="post">
                    {{csrf_field()}}
                    <label for="compte">Compte</label>
                    <select name="compte" id="compte" class="form-control">
                        @foreach(\App\Compte::all() as $compte)
                            <option value="{{$compte->id}}">{{$compte->libelle}}</option>
                        @endforeach
                    </select><br>
                    <label for="event">Evènement</label>
                    <select name="event" id="event" class="form-control">
                        @foreach(\App\Evenement::all() as $evenement)
                            <option value="{{$evenement->id}}">{{$evenement->libelle}}</option>
                        @endforeach
                    </select><br>

                    <label for="montant">Montant</label>
                    <input type="number" name="montant" min="0" id="montant" class="form-control"><br>

                    <label for="motif">Motif</label>
                    <input type="text" name="motif" id="motif" class="form-control"><br>

                    <label for="remarque">Remarque</label>
                    <input type="text" name="remarque" id="remarque" class="form-control"><br>

                    <label for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" class="form-control">
                        @foreach(\App\categorieDepense::all() as $categorie)
                            <option value="{{$categorie->id}}">{{$categorie->libelle}}</option>
                        @endforeach
                    </select><br>

                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                    <input type="reset" value="Réinitialiser" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
@endsection