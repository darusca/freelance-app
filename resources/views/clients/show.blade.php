@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            Client created {{ $client->created_at->diffForHumans() }} with project
                            <a href="#">{{ $client->projects->name }}</a>

                        <p>
                            {{--<subscribe-button :active="{{ json_encode($client->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>--}}

                            {{--<button class="btn btn-default"
                                    v-if="authorize('isAdmin')"
                                    @click="toggleLock"
                                    v-text="locked ? 'Unlock' : 'Lock'"></button>--}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
