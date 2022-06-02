@extends("layouts.app")
@section("title", "Entrées")
@section("content")

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="/entrees/store" method="post">
                    {{csrf_field()}}
                    <label for="compte">Compte</label><br>
                    <select name="compte" id="compte" class="form-control">
                        @foreach(\App\Compte::all() as $compte)
                            <option value="{{$compte->id}}">{{$compte->libelle}}</option>
                        @endforeach
                    </select><br>
                    <label for="montant">Montant</label>
                    <input id="montant" name="montant" type="number" min="0" placeholder="montant" class="form-control"><br>
                    <label for="source">Source</label>
                    <input type="text" name="source" id="source" class="form-control"><br>
                    <label for="remarque">Remarque</label>
                    <input type="text" name="remarque" id="remarque" class="form-control"><br>
                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>


@endsection