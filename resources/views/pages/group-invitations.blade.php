@extends('layouts.app')

@section('content')
    <div class="container">
        <invitations :invitations="{{ $invitations }}" ></invitations>
    </div>
@endsection
