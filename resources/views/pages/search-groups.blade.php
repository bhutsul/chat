@extends('layouts.app')

@section('content')
    <div class="container">
        <search :user="{{ auth()->user() }}"></search>
    </div>
@endsection
