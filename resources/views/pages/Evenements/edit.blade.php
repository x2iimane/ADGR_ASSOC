@extends("layouts.app")
@section("title", "Modifier un événement")
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php
                    $event = \App\Evenement::find($id);
                ?>
            </div>
            <div class="col-md-4">
                <form action="/evenement/update/{{$event->id}}" method="post">
                    {{csrf_field()}}
                    <label for="libelle">Libelle</label>
                    <input type="text" name="libelle" id="libelle" class="form-control" placeholder="Libelle" value="{{$event->libelle}}"><br>
                    <label for="type">Type</label>
                    <select name="typeEvent" id="typeEvent" class="form-control">
                        @foreach(\App\TypeEvent::all() as $eventType)
                            <option value="{{$eventType->id}}">{{$eventType->libelle}}</option>
                        @endforeach
                    </select><br>
                    <label for="dateDebut">Date début</label>
                    <input type="date" name="dateDebut" id="dateDebut" class="form-control" value="{{$event->date_debut}}"><br>
                    <label for="dateFin">Date fin</label>
                    <input type="date" name="dateFin" id="dateFin" class="form-control" value="{{$event->date_fin}}"><br>
                    <input type="submit" value="Modifier" class="btn btn-primary">
                    <input type="reset" value="Réinitialiser" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection