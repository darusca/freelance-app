@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                @if (count($tasks))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tasks
                        </div>

                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach ($tasks as $t)
                                    <li class="list-group-item">
                                        <a href="task/{{ $t->id }}">
                                            {{ $t->name }}
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