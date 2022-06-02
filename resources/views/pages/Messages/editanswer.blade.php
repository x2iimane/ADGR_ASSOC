@extends("layouts.app")
@section("title", "Modifier la réponse")
@section("content")
    <?php
    if(isset($id)){
        $message = \App\Message::find($id);
    }
    ?>
    <h4>Question:</h4>
    <div class="container-fluid" style="border: black solid 1px; border-radius: 10px 10px 0 0;">
        <div class="row" style="background-color: rgba(24,24,27,0.66); color: white; border-radius: 10px 10px 0 0;">
            <div class="col-md-1">
                @if($message->status == 1)
                    <h4><i class="glyphicon glyphicon-folder-open" style="text-align: right;"></i></h4>
                @else
                    <h4><i class="glyphicon glyphicon-folder-close" style="text-align: right;"></i></h4>
                @endif
            </div>
            <div class="col-md-10">
                <?php
                $statut = $message->status == 1?"Envoyé":"Clos";
                ?>
                <h4 style="text-align: center;"> {{$message->objet}} [{{$statut}}]</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2" style="text-align: center;">
                @if(file_exists("/storage/profilePhotos/donneurs/{{$message->donneur->id}}.jpg"))
                    <a href="/donneur/show/{{$message->donneur->id}}"><img src="/storage/profilePhotos/donneurs/{{$message->donneur->id}}.jpg" width="150px"></a>
                @else
                    <a href="/donneur/show/{{$message->donneur->id}}"><img src="/storage/logo.jpg" width="150px"></a><br>
                @endif
                <strong><a href="/donneur/show/{{$message->donneur->id}}">{{$message->donneur->nom." ".$message->donneur->prenom}}</a></strong><br>
                <?php
                $date = new DateTime(date( $message->created_at));
                ?>
                ({{$date->format("Y-m-d à H:i:s")}})
            </div>
            <div class="col-md-9">
                <div class="row" style="margin-top: 15px; position: relative;">
                    <div class="col-md-12">
                        {!! $message->contenu !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container-fluid">
        <div class="row" style="margin-bottom: 100px">
            @if($message->reponse != "")
                <h4>Réponse:</h4>
                <div class="container-fluid" style="border: black solid 1px; border-radius: 10px 10px 0 0;">
                    <div class="row" style="background-color: rgba(0,87,174,0.82); color: white; border-radius: 10px 10px 0 0;">
                        <div class="col-md-1">
                            @if($message->status == 1)
                                <h4><i class="glyphicon glyphicon-folder-open" style="text-align: right;"></i></h4>
                            @else
                                <h4><i class="glyphicon glyphicon-folder-close" style="text-align: right;"></i></h4>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <?php
                            $statut = $message->status == 1?"Envoyé":"Clos";
                            ?>
                            <h4 style="text-align: center;"> {{$message->objet}} [{{$statut}}]</h4>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-2" style="text-align: center;">
                            @if(file_exists("/storage/profilePhotos/donneurs/{{$message->benevole->id}}.jpg"))
                                <a href="/benevole/show/{{$message->benevole->id}}"><img src="/storage/profilePhotos/donneurs/{{$message->benevole->id}}.jpg" width="150px"></a>
                            @else
                                <a href="/benevole/show/{{$message->benevole->id}}"><img src="/storage/logo.jpg" width="150px"></a><br>
                            @endif
                            <strong><a href="/benevole/show/{{$message->benevole->id}}">{{$message->benevole->nom." ".$message->benevole->prenom}}</a></strong><br>
                            <?php
                            $date = new DateTime(date( $message->date_reponse));
                            ?>
                            ({{$date->format("Y-m-d à H:i:s")}})

                        </div>
                        <div class="col-md-9">
                            <div class="row" style="margin-top: 15px; position: relative;">
                                <div class="col-md-12">
                                    <form action="/message/answer/{{$message->id}}" method="post">
                                        {{csrf_field()}}
                                        <textarea name="reponse" class="form-control" placeholder="Votre réponse..." id="reponse">{{$message->reponse}}</textarea>
                                        <input type="submit" value="Modifier" class="btn btn-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'reponse' );
    </script>
@endsection