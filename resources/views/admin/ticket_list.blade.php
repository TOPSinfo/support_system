@extends('adminlte::page')

@section('title', 'Ticket list')

@section('content_header')
    <h1>Ticket list</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created by</th>
                                <th>Created at</th>
                                <th>Action</th>
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
                                    <td><a href="{{ route('admin.ticketDetail',['id' => $ticket->salted_hash_id]) }}"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop