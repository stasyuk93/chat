@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            @include('users')
            <div class="col-md-8 col-sm-12 h-100" id="chat-container">
                <div class="card h-100" id="chat-body">
                    <div class="card-header">Chat</div>
                    <div class="card-body h-100">
                        <div id="chat_output" class="" style="overflow-y:scroll">
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
                        <div class="h-25 mt-4">
                            <input id="chat_input" class="form-control " maxlength="200" placeholder="Write Message and Press Enter"/>
                            <div class="mt-1">
                                <button id="send-message" class="btn btn-success">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('notify')
    </div>
@endsection

@section('script')
    <script>
        const LIMIT_SECONDS = 15;

        const User = {
            isMute:0
        };

        @if($user->userOption)
            User.isMute = '{{$user->userOption->is_mute}}';
        @endif

        Object.defineProperties(User, {
            id:{
                value: "{{$user->id}}"
            },
            token:{
                value: "{{$user->getRememberToken()}}"
            },
            name:{
                value: "{{$user->name}}"
            },
            isAdmin: {
                value: "{{$user->isAdmin()}}"
            }
        });

        $('document').ready(function () {
            $("#chat_output").animate({scrollTop: $('#chat_output').prop("scrollHeight")}, 1000);
        });

    </script>
    <script src="{{asset('js/userColor.js')}}"></script>
    <script src="{{asset('js/chat.js')}}"></script>
    <script src="{{asset('js/socket.js')}}"></script>
    <script src="{{asset('js/sizer.js')}}"></script>
    @if($user->isAdmin())
        <script src="{{asset('js/admin.js')}}"></script>
    @endif
@endsection
