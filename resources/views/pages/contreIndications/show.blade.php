
@extends('layouts.app')

@section('content')
    <h1>
        {{$ci->nom}}
    </h1>
    <p>
        <a href="/contre_indications/{{$ci->id}}/edit" class="btn btn-default"> Edit </a>
    </p>
    {!!Form::open(['action' => ['ContreIndicationsController@destroy', $ci->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection