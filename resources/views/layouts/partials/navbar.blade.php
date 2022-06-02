<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    {{--<a class="navbar-brand" href="/"><img src="{{asset("/storage/logo.jpg")}}" height="35px"></a>--}}
    <a class="navbar-brand" href="/">ADGR</a>
</div>

<ul class="nav navbar-top-links navbar-right">
    @if(Auth::guard("benevole")->check())
        <li class="dropdown">
            @include("layouts.partials.dropdowns.messages")
        </li>
    @endif
    {{--<li class="dropdown">--}}
        {{--@include("layouts.partials.dropdowns.tasks")--}}
    {{--</li>--}}
    {{--<li class="dropdown">--}}
        {{--@include("layouts.partials.dropdowns.alerts")--}}
    {{--</li>--}}
    <li class="dropdown">
        @include("layouts.partials.dropdowns.user")
    </li>
</ul>