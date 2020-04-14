@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create group</div>

                    <div class="card-body">
                        <form method="POST" action="{{ asset('create') }}">
                            <div class="groupName">
                                <label for="exampleInputEmail1">Group name</label>
                                <input type="text" class="form-control" id="groupName" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="groupStatus">Status group</label>
                                <select class="form-control" id="groupStatus">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection