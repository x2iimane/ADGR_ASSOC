@extends("layouts.app")
@section("title","Nouvelle zone")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <form action="/zone/store" method="post">
                    {{csrf_field()}}
                    @if(Auth::user()->role->id == 1)
                        <label for="libVille">Ville</label>
                        <select id='libVille' name="ville_id" class="form-control">
                            @foreach(App\Ville::all() as $ville)
                                @if($idVille == $ville->id)
                                    <option value="{{$ville->id}}" selected>{{$ville->libVille}}</option>
                                @else
                                    <option value="{{$ville->id}}">{{$ville->libVille}}</option>
                                @endif
                            @endforeach
                        </select><br>
                    @else
                        <input type="hidden" name="ville_id" value="{{Auth::user()->zone->ville->id}}">
                    @endif
                    <label for="libZone">Libellé zone</label>
                    <input type="text" name="libZone" id="libZone" class="form-control"><br>
                    <label for="codePostal">Code postal</label>
                    <input type="number" name="codePostal" id="codePostal" class="form-control"><br>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection