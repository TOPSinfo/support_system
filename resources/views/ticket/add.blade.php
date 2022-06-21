@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Ticket</div>

                <div class="card-body">
                    <form method="post" action="{{ route('ticket.save') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Save</button>
                        <a href="{{ route('ticket.list') }}" class="btn btn-danger mb-2" role="button" aria-pressed="true">Close</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
