@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                @if (count($projects))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Projects
                        </div>

                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach ($projects as $p)
                                    <li class="list-group-item">
                                        <a href="project/{{ $p->id }}">
                                            {{ $p->name }}
                                            {{ $p->client->name }}
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