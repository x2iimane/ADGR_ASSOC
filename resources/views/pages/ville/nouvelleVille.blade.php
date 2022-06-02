@extends("layouts.app")
@section("title","Nouvelle ville")
@section("content")
    <div class="container">
        @if(count(\App\Bureau::all()) > 0)
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-4">
                    <form action="/ville/store" method="post">
                        {{csrf_field()}}
                        <label for="libVille">Libellé ville</label><input type="text" name="libVille" class="form-control" id="libVille"><br>
                        <label for="bureau">Bureau</label><br>
                        <select name="bureau" id="bureau" class="form-control">
                            @foreach(\App\Bureau::all() as $bureau)
                                <option value="{{$bureau->id}}">{{"Bureau : ".$bureau->id}}</option>
                            @endforeach
                        </select><br>
                        <input type="submit" value="Ajouter" class="btn btn-primary">
                        <input type="reset" value="Annuler" class="btn btn-primary">
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Créez un bureau d'abord !
            </div>
        @endif
    </div>
@endsection