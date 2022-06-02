@extends("layouts.app")
@section("title","Modifier zone")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <?php
                $zone = App\Zone::find($idZone);
            ?>
            <div class="col-md-4">
                <form action="/zone/update/{{$zone->id}}" method="post">
                    {{csrf_field()}}
                    <label for="libVille">Ville</label>
                    <select id='libVille' name="ville_id" class="form-control">
                        @foreach(App\Ville::all() as $ville)
                            @if($zone->ville->id == $ville->id)
                                <option value="{{$ville->id}}" selected>{{$ville->libVille}}</option>
                            @else
                                <option value="{{$ville->id}}">{{$ville->libVille}}</option>
                            @endif
                        @endforeach
                    </select><br>
                    <label for="libZone">Libellé zone</label>
                    <input type="text" name="libZone" id="libZone" class="form-control" value={{$zone->libZone}}><br>
                    <label for="codePostal">Code postal</label>
                    <input type="number" name="codePostal" id="codePostal" class="form-control" value={{$zone->codePostal}}><br>
                    <input type="submit" value="Ajouter" class="btn btn-primary">

                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection