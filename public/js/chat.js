const Chat = {};

Chat.sendMessage = function (WS) {
    if(WS instanceof WebSocket){
        let timer = new Date() ;
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

Chat.getOnlineUsersForClient = function (WS) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'getOnlineUsersForClient'
            })
        );
    }
};

Chat.event = function (event, data) {
    if(event in this){
        this[event](data);
    } else {
        console.log(event + 'not exists');
    }
};

// Chat.close = function (WS) {
//     if(WS instanceof WebSocket){
//         WS.send(
//             JSON.stringify({
//                 'event': 'onClose',
//                 'user_id': User.id
//             })
//         );
//     }
// };

Chat.onMessage = function (data) {
    console.log(data);

    let msg = $('<div>');
    msg.addClass('border-bottom border-secondary')
        .append($('<h4>').append(data.user_name + ':').css('color',UsersColor.storage[data.user_id].name))
        .append($('<p>').append(data.message).css('color',UsersColor.storage[data.user_id].message))
        .append($('<div>').addClass('text-right').append($('<span>').addClass('text-muted').append(this.now())));
    $('#chat_output').append(msg);
    $("#chat_output").animate({scrollTop: $('#chat_output').prop("scrollHeight")}, 1000);
};

Chat.getOnlineUsers = function (data) {
    console.log(data);
    this.renderUserList(data);
};

Chat.onClose = function(data){
    this.renderUserList(data);
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
    $('#total-users').html(data.users.length);
    let content = [];
    $(data.users).each(function(){
        if(!(this.id in UsersColor.storage)) UsersColor.add(this.id);
        let li = $('<li>').css('color', UsersColor.storage[this.id].name).attr('user_id', this.id).append(this.name);
        content.push(li);
    });
    $('#list-users').html(content);
};
