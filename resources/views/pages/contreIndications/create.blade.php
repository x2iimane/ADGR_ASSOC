@extends("layouts.app")
@section("title","Nouvelle contre-indication")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <form action="/contreIndication/store" method="post">
                    {{csrf_field()}}
                    <label for="nom">Nom de la contre-indication</label><input type="text" name="nom" class="form-control" id="nom"><br>
                    <input type="radio" name="type" value="provisoire" id="provisoire" checked> <label for="provisoire">Provisoire</label><br>
                    <input type="radio" name="type" value="definitive" id="definitive"> <label for="definitive">Définitive</label><br>
                    <div id="dureediv">
                        <label for="duree">Durée de la contre-indication</label>
                        <input type="text" name="duree" class="form-control" id="duree"><br>
                        <select name="unite" class="form-control">
                            <option value="j">Jours</option>
                            <option value="m">Mois</option>
                            <option value="a">Années</option>
                        </select><br>
                    </div>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script
            src="/js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            $("#definitive").on("change", function(){
                $("#dureediv").fadeOut();
            })
            $("#provisoire").on("change", function(){
                $("#dureediv").fadeIn();
            })
        });
    </script>
@endsection