@extends('layouts.app')

@section('content')
    <div class="container">
        <requests :requests="{{ $requests }}" ></requests>
    </div>
@endsection
