const Chat = {eventContainer:{}};

Chat.init = function (WS) {
    if(WS instanceof WebSocket){
        let timer = new Date() ;
        $('#chat_input').on('keyup', function (e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                if(WS.readyState != 1){
                    $('#alert #notify').text('Connection closed');
                    return $('#alert').modal('show');
                }
                if(+User.isMute) {
                    $('#alert #notify').text('You are muted');
                    return $('#alert').modal('show');
                }
                if((timer > new Date())) {
                    let refreshId = setInterval(function() {
                        let time = Math.floor((timer - new Date()) / 1000);
                        $('#alert #notify').text('Wait '+ time + ' seconds');
                        if(time <= 0) {
                            clearInterval(refreshId);
                            $('#alert').modal('hide');
                        }
                    }, 100);
                    return $('#alert').modal('show');
                }
                timer = new Date(Date.now() + LIMIT_SECONDS * 1000);
                let chat_msg = $(this).val();
                WS.send(
                    JSON.stringify({
                        'event': 'onMessage',
                        'user_id': User.id,
                        'user_name': User.name,
                        'message': chat_msg
                    })
                );
                $(this).val('');
            }
        });
    }
};

Chat.addEvent = function(event,method){
    this.eventContainer[event] = method.bind(this);
};

Chat.event = function (event, data) {
    if(event in this.eventContainer){
        this.eventContainer[event](data);
    } else {
        console.log(event + ' not exists');
    }
};

Chat.addEvent('onMessage', function (data) {
    console.log(data);

    let msg = $('<div>');
    msg.addClass('border-bottom border-secondary')
        .append($('<h4>').append(data.user_name + ':').css('color',UsersColor.storage[data.user_id].name))
        .append($('<p>').append(data.message).css('color',UsersColor.storage[data.user_id].message))
        .append($('<div>').addClass('text-right').append($('<span>').addClass('text-muted').append(this.now())));
    $('#chat_output').append(msg);
    $("#chat_output").animate({scrollTop: $('#chat_output').prop("scrollHeight")}, 1000);
});

Chat.addEvent('getOnlineUsers', function (data) {
    console.log(data);
    this.renderUserList(data);
});

Chat.addEvent('onClose', function(data){
    this.renderUserList(data);
});

Chat.addEvent('onMuteClient',function (data) {
    User.isMute = 1;
    $('#alert #notify').text('You are muted');
    $('#alert').modal('show');
});

Chat.addEvent('unMuteClient',function (data) {
    User.isMute = 0;
    $('#alert #notify').text('You are unmuted');
    $('#alert').modal('show');
});

Chat.getOnlineUsersForClient = function (WS) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'getOnlineUsersForClient'
            })
        );
    }
};

Chat.now = function (){
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
};

Chat.renderUserList = function (data) {
    $('#user-container #total-users').html(data.users.length);
    let content = [];
    $(data.users).each(function(){
        let isBan = 0;
        let isMute = 0;
        if(!(this.id in UsersColor.storage)) UsersColor.add(this.id);
        let li = $('<li>').addClass('list-group-item list-group-item-action').css('color', UsersColor.storage[this.id].name).attr('user_id', this.id).append(this.name);
        if(this.user_option){
            isBan = this.user_option.is_ban;
            isMute = this.user_option.is_mute;
        }
        $(li).attr('is_ban', isBan).attr('is_mute', isMute);
        content.push(li);
    });
    $('#user-container #title-users').html('Online users: ');

    $('#user-container #list-users').html(content);
};
