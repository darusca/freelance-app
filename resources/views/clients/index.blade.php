@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                @if (count($clients))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Clients
                        </div>

                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach ($clients as $c)
                                    <li class="list-group-item">
                                        <a href="client/{{ $c->id }}">
                                            {{ $c->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection