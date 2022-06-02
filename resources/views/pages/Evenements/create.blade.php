@extends("layouts.app")
@section("title", "Créer un événement")
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-4">
                <form action="/evenement/store" method="post">
                    {{csrf_field()}}
                    <label for="libelle">Libelle</label>
                    <input type="text" name="libelle" id="libelle" class="form-control" placeholder="Libelle"><br>
                    <label for="type">Type</label>
                    <select name="typeEvent" id="typeEvent" class="form-control">
                        @foreach(\App\TypeEvent::all() as $eventType)
                            <option value="{{$eventType->id}}">{{$eventType->libelle}}</option>
                        @endforeach
                    </select><br>
                    <div id="typeCollecteDiv">

                    </div>
                    <div id="formCollecte" class="alert alert-info">

                    </div>
                    <label for="dateDebut">Date début</label>
                    <input type="date" name="dateDebut" id="dateDebut" class="form-control"><br>
                    <label for="dateFin">Date fin</label>
                    <input type="date" name="dateFin" id="dateFin" class="form-control"><br>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                    <input type="reset" value="Réinitialiser" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script src="/js/createEvent.js"></script>
@endsection