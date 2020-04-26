@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Groups</div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><a class="nav-link" href="{{ route('search') }}">{{ __('Search groups') }}</a></li>
                        <li class="list-group-item"><a class="nav-link" href="{{ route('create') }}">{{ __('Create group') }}</a></li>
                        <li class="list-group-item"><a class="nav-link" href="{{ route('invitations') }}">{{ __('Group invitations') }}</a></li>
                        <li class="list-group-item"><a class="nav-link" href="{{ route('requests') }}">{{ __('Group requests') }}</a></li>
                        <li class="list-group-item"><a class="nav-link" href="{{ route('showMyGroups') }}">{{ __('My groups') }}</a></li>
                        <li class="list-group-item"><a class="nav-link" href="{{ route('showAllGroups') }}">{{ __('All groups') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
