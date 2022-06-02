@extends("layouts.app")
@section("title","Modifier bureau")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <form action="/bureau/update/{{$idBureau}}" method="post">
                    {{csrf_field()}}
                    <?php
                        $bureau = App\Bureau::find($idBureau)
                    ?>

                    <label for="villes">Villes</label><br>
                    @foreach(\App\Ville::all() as $ville)
                        <label for="ville{{$ville->id}}">{{$ville->libVille}}</label>
                        <input type="checkbox" name="villes[]" value="{{$ville->id}}" id="ville{{$ville->id}}">
                    @endforeach
                    <br><label for="dateCreation">Date de création</label>
                    <input type="date" class="form-control" id="dateCreation" name="dateCreation" value={{$bureau->dateCreation}}><br>
                    <input type="submit" value="Modifier" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection