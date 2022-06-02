@extends("layouts.app")
@section("title", "Creer un compte")
@section("content")
    <?php
        $compte = App\Compte::find($idCompte);
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-4">
                <form action="/compte/update/{{$compte->id}}" method="post">
                    {{csrf_field()}}
                    <label for="libelle">Libelle</label>
                    <input type="text" name="libelle" id="libelle" placeholder="Libelle" class="form-control" value="{{$compte->libelle}}"><br>
                    <label for="type">Type</label>
                    <select class="form-control" name="type" value="{{$compte->type}}">
                        <option value="1">Principal</option>
                        <option value="0">Secondaire</option>
                    </select><br>
                    <label for="Solde">Solde</label>
                    <input type="text" name="solde" id="Solde" placeholder="Solde initial" class="form-control" value="{{$compte->solde}} DH" disabled><br>
                    <input type="submit" value="Modifier" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection