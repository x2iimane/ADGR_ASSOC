@extends("layouts.app")
@section("title","Modifier un message")
@section("content")
    <?php
        $message  = \App\Message::find($id);
    ?>

    <form action="/message/update/{{$message->id}}" method="post">
        {{csrf_field()}}
        <label for="objet">Objet</label>
        <select name="objet" id="objet" class="form-control" style="width:50%;">
            <option value="Demande de modification d'une/des information.s">Demande de modification d'une/des information.s</option>
            <option value="Remarque/Reclamation">Remarque/Récamation</option>
        </select><br>
        <label for="message">Message</label><textarea id="message" name="contenu" class="form-control" placeholder="Votre Message" style="width:50%;">{{$message->contenu}}</textarea><br>
        <input type="hidden" name="donneur" class="btn btn-primary" value="{{Auth::user()->id}}">
        <input type="submit" class="btn btn-primary" value="Envoyer">
        <input type="reset" class="btn btn-primary" value="Annuler">
    </form>

    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'message' );
    </script>
@endsection