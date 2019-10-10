@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card" id="chat-body">
                    <div class="card-header">Chat</div>
                    <div class="card-body">
                        <div id="chat_output" class="pre-scrollable" style="min-height: 600px">
                            @foreach($messages as $message)
                                <div user_id = "{{$message->user_id}}" class="border-bottom border-secondary">
                                    <h4 class="user-name">{{$message->user->name}}:</h4>
                                    <p class="message">{{$message->text}}</p>
                                    <div class="text-right">
                                        <span class="text-muted">{{\Carbon\Carbon::parse($message->created_at,'UTC')->timezone('Europe/Kiev')}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input id="chat_input" class="form-control mt-4" maxlength="200" placeholder="Write Message and Press Enter"/>
                    </div>
                </div>
            </div>
            @include('users')
        </div>
        <div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="timer"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const LIMIT_SECONDS = 15;

        const User = {};

        Object.defineProperties(User, {
            id:{
                value: "{{auth()->user()->id}}"
            },
            token:{
                value: "{{auth()->user()->getRememberToken()}}"
            },
            name:{
                value: "{{auth()->user()->name}}"
            }
        });

        $('document').ready(function () {
            $("#chat_output").animate({scrollTop: $('#chat_output').prop("scrollHeight")}, 1000); // Scroll the chat output div
        });
    </script>
    <script src="{{asset('js/userColor.js')}}"></script>
    <script src="{{asset('js/chat.js')}}"></script>
    <script src="{{asset('js/socket.js')}}"></script>

    @if(auth()->user()->isAdmin())
        <script src="{{asset('js/admin.js')}}"></script>
    @endif
@endsection
