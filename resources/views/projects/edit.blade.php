@extends('layouts.app')

@section('content')
    @foreach($proj as $p)
    {{ $p->name }}
    @endforeach
@endsection