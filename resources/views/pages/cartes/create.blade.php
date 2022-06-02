@extends("layouts.app")
@section("title","Nouvelle carte")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <form action="/carte/store" method="post">
                    {{csrf_field()}}
                    <label for="donneur_id">Donneur</label>
                    {{--<input type="text" name="donneur_id" id="donneur_id" class="form-control"><br>--}}
                    <select name="donneur_id" class="form-control">
                        @foreach(App\Donneur::all() as $donneur)
                            <option value={{$donneur->id}}>{{$donneur->nom}} {{$donneur->prenom}} ({{$donneur->CIN}})</option>
                        @endforeach
                    </select><br>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection