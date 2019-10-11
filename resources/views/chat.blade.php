@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12">
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
                        <div class="mt-3">
                            <button id="send-message" class="btn btn-success float-right">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('users')
        </div>
        @include('notify')
    </div>
@endsection

@section('script')
    <script>
        const LIMIT_SECONDS = 15;

        const User = {isMute:0};
        @if(auth()->user()->userOption)
            User.isMute = '{{auth()->user()->userOption->is_mute}}';
        @endif
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
