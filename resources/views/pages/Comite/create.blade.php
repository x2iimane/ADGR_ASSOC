@extends("layouts.app")
@section("title", "Former un comité")
@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="{{route("comite.store")}}" method="post">
                {{csrf_field()}}
                <label for="libelle">Libelle</label>
                <input type="text" id="libelle" name="libelle" class="form-control" placeholder="Libelle">
                <fieldset>
                    <legend>Membres</legend>
                    @foreach(\App\Benevole::all() as $benevole)
                        @if($benevole->etat == "1")
                            <input type="checkbox" class="membres" data-nom="{{$benevole->nom." ". $benevole->prenom}}" name="membres[]" value="{{$benevole->id}}" id="benevole{{$benevole->id}}"> <label for="benevole{{$benevole->id}}">{{$benevole->nom." ". $benevole->prenom}}</label>
                            <a href="/benevole/show/{{$benevole->id}}">Afficher...</a><br>
                        @endif
                    @endforeach
                </fieldset><br>
                <div id="selectRespo">
                    <label for="responsable">Responsable</label>
                    <div class="well">Choisissez un membre !</div>
                </div>
                <input type="submit" value="Enregistrer" class="btn btn-primary">
                <input type="reset" value="Annuler" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
<script src="/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        $(".membres").on("change", function(){
            let html = "<label for=\"responsable\">Responsable</label>" +
                "<select name='responsable' id='responsable' class='form-control'>";
            let flag = false;
            $(".membres").each(function(){
                if($(this).prop("checked") === true){
                    html += "<option value='"+$(this).attr("value")+"'>"+$(this).attr("data-nom")+"</option>"
                    flag = true;
                }
            });
            html +="</select><br>";
            if(!flag) html="<div class=\"well\">Choisissez un membre !</div>";
            $("#selectRespo").html(html);
        });
    });
</script>
@endsection