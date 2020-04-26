@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Groups</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @isset($groups)
                                @foreach($groups as $group)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $group->name }}
                                        <a href="{{ asset('group/'. $group->id .'') }}" class="btn btn-outline-success">Go</a>
                                    </li>
                                @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection