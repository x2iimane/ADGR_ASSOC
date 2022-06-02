@extends("layouts.app")
@section("title","Nouveau bureau")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(count(\App\Benevole::all())==0)
                    <div class="alert alert-warning">
                        Vous devez ajouter un benevole d'abord !
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">

                <form action="/bureau/store" method="post">
                    {{csrf_field()}}
                    <label for="dateCreation">Date de création</label>
                    <input type="date" name="dateCreation" id="dateCreation" class="form-control"><br>
                    <label for="responsable">Responsable</label><br>
                    <select name="responsable" class="form-control" id="responsable">
                        @foreach(\App\Benevole::all() as $benevole)
                            @if(Auth::user()->role->id != 1)
                                @if($benevole->zone->ville->id == Auth::user()->zone->ville->id)
                                    <option value="{{$benevole->id}}">{{$benevole->nom." ".$benevole->prenom}}</option>
                                @endif
                            @else
                                <option value="{{$benevole->id}}">{{$benevole->nom." ".$benevole->prenom}}</option>
                            @endif
                        @endforeach
                    </select><br>
                    @if(Auth::user()->role->id != 1)
                        Ville:<br>
                        <label for="villes">{{Auth::user()->zone->ville->libVille}}</label>
                        <input id="villes" type="checkbox" name="villes[]" value="{{Auth::user()->zone->ville->id}}" checked>
                    @else
                        <label for="villes">Villes</label><br>
                        @foreach(\App\Ville::all() as $ville)
                            <label for="ville{{$ville->id}}">{{$ville->libVille}}</label>
                            <input type="checkbox" name="villes[]" value="{{$ville->id}}" id="ville{{$ville->id}}"><br>
                        @endforeach
                    @endif
                    <br>
                    @if(count(\App\Benevole::all())>0)
                        <input type="submit" value="Ajouter" class="btn btn-primary">
                        <input type="reset" value="Annuler" class="btn btn-primary">
                    @else
                        <input type="submit" value="Ajouter" class="btn btn-primary" disabled>
                        <input type="reset" value="Annuler" class="btn btn-primary">
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection