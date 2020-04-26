@extends('layouts.app')

@section('content')
    <div class="container">
        <edit-group :group="{{ $group }}" :auth_user="{{ auth()->user() }}"></edit-group>
    </div>
@endsection