@extends("layouts.app")
@section("title", "Creer un compte")
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-4">
                <form action="/compte/store" method="post">
                    {{csrf_field()}}
                    <label for="libelle">Libelle</label>
                    <input type="text" name="libelle" id="libelle" placeholder="Libelle" class="form-control"><br>
                    <label for="type">Type</label>
                    <select class="form-control" name="type">
                        <option value="1">Principal</option>
                        <option value="0">Secondaire</option>
                    </select><br>
                    <label for="Solde">Solde initial</label>
                    <input type="text" name="solde" id="Solde" placeholder="Solde initial" class="form-control"><br>
                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection