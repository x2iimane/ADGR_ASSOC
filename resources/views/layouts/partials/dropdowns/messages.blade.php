<style>
    @keyframes nouveauMessage{
        0% {color: #0d6aad;}
        50% {color: red;}
        100% {color: #0d6aad;}
    }
    #msgDropDown{
        animation-name: nouveauMessage;
        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        -o-animation-duration: 1s;
        animation-duration: 1s;
        animation-iteration-count: infinite;
    }

</style>
    <?php
    $c = 0;
    ?>
    @if(count(\App\Message::where("status", "=", "1")->get()))
        <a class="dropdown-toggle" id="msgDropDown" data-toggle="dropdown" href="#">
            <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
    @else
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
    @endif
    <ul class="dropdown-menu dropdown-messages">
        <?php
        $c = 0;
        ?>
        @foreach(\App\Message::all() as $msg)
            @if($c != 0)
                <li class="divider"></li>
            @endif
            @if($msg->status == 1)
                <?php
                    $c++;
                    $dt = \Carbon\Carbon::now();
                    $past = \Carbon\Carbon::createFromFormat("Y-m-d H:i:s",$msg->created_at);
                    $date = $dt->diffForHumans($past);
                ?>
                <li>
                    <a href="/message/show/{{$msg->id}}">
                        <div>
                            <strong>{{$msg->donneur->nom." ".$msg->donneur->prenom}}</strong>
                            <span class="pull-right text-muted">
                                        <em>{{$date}}</em>
                                    </span>
                        </div>
                        <div>{!!  str_limit($msg->contenu, 35) !!}</div>
                    </a>
                </li>
            @endif
        @endforeach
            @if($c == 0)
                <li>
                    <a href="#">
                        <div>
                            {{--<strong>{{$msg->donneur->nom." ".$msg->donneur->prenom}}</strong>--}}
                            {{--<span class="pull-right text-muted">--}}
                            {{--<em></em>--}}
                            {{--</span>--}}
                        </div>
                        <div>{{"Aucun message !"}}</div>
                    </a>
                </li>
            @endif
    </ul>
    <!-- /.dropdown-messages -->