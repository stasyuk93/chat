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
                                <div user_id = "{{$message->user_id}}" class="@if($message->user_id == auth()->id())text-success @else text-info @endif border-bottom border-secondary">
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
    <script src="{{asset('js/chat.js')}}"></script>

    <script>
        const LIMIT_SECONDS = 15;
        function GetNow(){
            function formatDate(number) {
                let string = number.toString();
                if (string.length == 1) return '0'+string;
                return number;
            }
            let currentdate = new Date();
            let datetime =
                currentdate.getFullYear() + "-"
                + formatDate(currentdate.getMonth()+1) + "-"
                + formatDate(currentdate.getDate()) + " "
                + formatDate(currentdate.getHours()) + ":"
                + formatDate(currentdate.getMinutes()) + ":"
                + formatDate(currentdate.getSeconds());
            return datetime;
        }
        $('document').ready(function () {
            $("#chat_output").animate({scrollTop: $('#chat_output').prop("scrollHeight")}, 1000); // Scroll the chat output div
        });
        // Websocket
        let ws = new WebSocket("ws://localhost:8090");
        ws.onopen = function (e) {
            let timer = new Date() ;

            // Connect to websocket
            ws.send(
                JSON.stringify({
                    'type': 'connect',
                    'user_id': '{{auth()->id()}}'
                })
            );
            // Bind onkeyup event after connection
            $('#chat_input').on('keyup', function (e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    if((timer > new Date())) {
                        let refreshId = setInterval(function() {
                            let time = Math.floor((timer - new Date()) / 1000);
                            $('#alert #timer').text('Wait '+ time + ' seconds');
                            if(time <= 0) {
                                clearInterval(refreshId);
                                $('#alert').modal('hide');
                            }
                        }, 1000);
                        return $('#alert').modal('show');
                    }
                    timer = new Date(Date.now() + LIMIT_SECONDS * 1000);
                    let chat_msg = $(this).val();
                    ws.send(
                        JSON.stringify({
                            'type': 'chat',
                            'user_id': '{{auth()->id()}}',
                            'user_name': "{{auth()->user()->name}}",
                            'message': chat_msg
                        })
                    );
                    $(this).val('');
                    console.log('{{auth()->id()}} sent ' + chat_msg);
                }
            });
            UsersColor.add('{{auth()->id()}}');
        };
        ws.onerror = function (e) {
            // Error handling
            console.log(e);
        };
        ws.onclose = function(e) {
            ws.send(
                JSON.stringify({
                    'type': 'disconnect',
                    'user_id': '{{auth()->id()}}'
                })
            );
        };
        ws.onmessage = function (e) {
            let json = JSON.parse(e.data);

            switch (json.type) {
                case 'chat':
                    let msg = $('<div>');
                    (json.user_id == '{{auth()->id()}}')? msg.addClass('text-success') : msg.addClass('text-info');
                    msg.addClass('border-bottom border-secondary')
                        .append($('<h4>').append(json.user_name + ':'))
                        .append($('<p>').append(json.message))
                        .append($('<div>').addClass('text-right').append($('<span>').addClass('text-muted').append(GetNow())));
                    console.log(msg);
                    $('#chat_output').append(msg); // Append the new message received
                    $("#chat_output").animate({scrollTop: $('#chat_output').prop("scrollHeight")}, 1000); // Scroll the chat output div
                    console.log("Received " + json.message);
                    break;
                case 'socket':
                    $('#total-users').html(json.users.length);
                    let content = [];
                    $(json.users).each(function(){
                        if(!(this.id in UsersColor)) UsersColor.add(this.id);
                        let li = $('<li>').css('color', UsersColor[this.id].name).attr('user_id', this.id).append(this.name);
                        content.push(li);
                    });
                    $('#list-users').html(content);

                    break;
            }
        };
        // ws.on('')

    </script>
@endsection
