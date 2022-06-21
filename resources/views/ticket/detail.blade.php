@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $ticket->title }}</h3>
                    <div class="card-tools">
                        <div class="user-block">
                            <span class="description">{{ $ticket->created_at }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="post">
                        <!-- /.user-block -->
                        <p>
                            {{ $ticket->description }}
                        </p>

                        <p>
                            &nbsp;
                            <span class="float-right">
                                <a href="javascript:void(0);" class="link-black text-sm">
                                    <i class="far fa-comments mr-1"></i> Comments ({{ $ticket->comments->count() }})
                                </a>
                            </span>
                        </p>
                        @foreach($ticket->comments as $comment)
                            <div class="border border-primary rounded mb-3">
                                <p class="ml-3">
                                    {{ $comment->message }}
                                    <span class="float-right mr-1">{{ $comment->user->name }} {{ $comment->created_at }}</span>
                                </p>
                                @if(!empty($comment->image_name))
                                    <img class="ml-3" src="{{ asset('files/'.$comment->image_name) }}" width="100">
                                @endif
                            </div>
                        @endforeach
                        <br>
                        <form id="comment_form">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <div class="form-group">
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Attachment
                                        <input type="file" id="attachment" name="attachment" accept="image/png, image/gif, image/jpeg">
                                    </div>
                                    <p class="help-block">Max. 32MB</p>
                                </div>
                                <div class="col-md-6">
                                    <a href="javascript:void(0);" class="btn btn-primary float-right" id="commentPost" role="button" aria-pressed="true">Send</a>
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('ticket.list') }}" class="btn btn-danger mb-2" role="button" aria-pressed="true">Close</a>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            $(document).on("click","#commentPost",function() {
                event.preventDefault();
                var form = $('#comment_form')[0];
                var data = new FormData(form);
                // disabled the submit button
                $("#commentPost").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "{{ route('ticket.comment') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function (data) {
                        if (data.success == '1') {
                            location.reload();
                            console.log("SUCCESS : ", data);
                            $("#commentPost").prop("disabled", false);
                        } else {
                            alert("Please add comment message or attachment.");
                            $("#commentPost").prop("disabled", false);
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                        $("#commentPost").prop("disabled", false);
                    }
                });
            });
        });
    </script>
@stop
