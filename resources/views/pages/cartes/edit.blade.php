@extends("layouts.app")
@section("title","Modifier carte")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <?php
                $carte = App\Carte::find($id);
            ?>
            <div class="col-md-4">
                <form action="/carte/update/{{$id}}" method="post">
                    {{csrf_field()}}
                    <label for="etatCarte">Etat de la carte</label>
                    <select id="etatCarte" name="etatCarte" class="form-control">
                        <option value="2">Imprimée</option>
                        <option value="3">Livrée</option>
                    </select><br>
                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection