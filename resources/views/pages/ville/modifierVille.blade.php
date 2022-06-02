@extends("layouts.app")
@section("title","Modifier ville")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <form action="/ville/update/{{$idVille}}" method="post">
                    {{csrf_field()}}
                    <?php
                        $ville = App\Ville::find($idVille);
                    ?>
                    <label for="libVille">Libellé ville</label><input type="text" name="libVille" class="form-control" id="libVille" value={{$ville->libVille}}><br>
                    <label for="bureau">Bureau</label><br>
                    <select id="bureau" name="bureau" class="form-control">
                        @foreach(\App\Bureau::all() as $bureau)
                            <option value="{{$bureau->id}}">{{"Bureau : ".$bureau->id}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection