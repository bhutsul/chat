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
                                        <div class="justify-content-around">
                                            <a href="{{ asset('group/'. $group->id .'') }}" class="btn btn-outline-success">Go</a>
                                            <a href="{{ asset('group/'. $group->id .'/edit') }}" class="btn btn-outline-primary">Edit</a>
                                        </div>
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