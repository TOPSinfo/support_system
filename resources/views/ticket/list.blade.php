@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-header">
                    Tickets
                    <a href="{{ route('ticket.add') }}" class="btn btn-primary float-right" role="button" aria-pressed="true">Add</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created by</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <th scope="row">{{$sn++}}</th>
                                    <td>{{$ticket->title}}</td>
                                    <td>
                                        @if($ticket->status == '1')
                                            <a href="#" class="btn btn-info" role="button" aria-pressed="true">Pending</a>
                                        @elseif($ticket->status == '2')
                                            <a href="#" class="btn btn-warning" role="button" aria-pressed="true"> In Progress</a>
                                        @elseif($ticket->status == '3')
                                            <a href="#" class="btn btn-success" role="button" aria-pressed="true">Completed</a>
                                        @elseif($ticket->status == '4')
                                            <a href="#" class="btn btn-danger" role="button" aria-pressed="true">Rejected</a>
                                        @endif
                                    </td>
                                    <td>{{$ticket->user->name}}</td>
                                    <td>{{$ticket->created_at}}</td>
                                    <td><a href="{{ route('ticket.edit',['id' => $ticket->salted_hash_id]) }}"><i class="fas fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
