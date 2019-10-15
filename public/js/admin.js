Chat.addEvent('showAllUsers', function(data){
    this.renderUserList(data);
    $('#user-container #title-users').html('All users: ');
});

Chat.getAllUsers = function () {
    WS.send(
        JSON.stringify({
            'event': 'getAllUsers'
        })
    );
};

Chat.banUser = function (user_id) {
    WS.send(
        JSON.stringify({
            'event': 'banUser',
            'user_id': user_id
        })
    );
};

Chat.unBanUser = function (user_id) {
    WS.send(
        JSON.stringify({
            'event': 'unBanUser',
            'user_id': user_id
        })
    );
};

Chat.muteUser = function (user_id) {
    WS.send(
        JSON.stringify({
            'event': 'muteUser',
            'user_id': user_id
        })
    );
};

Chat.unMuteUser = function (user_id) {
    WS.send(
        JSON.stringify({
            'event': 'unMuteUser',
            'user_id': user_id
        })
    );
};

Chat.addEvent('onBan',function (data) {
    let id = data.user_id;
    $('#user-container #list-users li[user_id='+id+']').attr('is_ban', 1).trigger('click');
});

Chat.addEvent('unBan',function (data) {
    let id = data.user_id;
    $('#user-container #list-users li[user_id='+id+']').attr('is_ban', 0).trigger('click');
});

Chat.addEvent('onMute',function (data) {
    let id = data.user_id;
    $('#user-container #list-users li[user_id='+id+']').attr('is_mute', 1).trigger('click');
});

Chat.addEvent('unMute',function (data) {
    let id = data.user_id;
    $('#user-container #list-users li[user_id='+id+']').attr('is_mute', 0).trigger('click');
});

$('#user-container #show-all-users').click(function(){
    $('#user-container #admin-option .dropdown-menu').children().addClass('disabled');
    Chat.getAllUsers();
});

$('#user-container #show-online-users').click(function(){
    $('#user-container #admin-option .dropdown-menu').children().addClass('disabled');
    Chat.getOnlineUsersForClient();
});

$('#user-container #list-users').on('click','li',function () {
    $('#user-container #admin-option .dropdown-menu').children().removeClass('disabled');
    let banTitle = 'Ban user';
    let muteTitle = 'Mute user';
    let banEvent = 'banUser';
    let muteEvent = 'muteUser';
    if(+$(this).attr('is_ban')){
        banEvent = 'unBanUser';
        banTitle = 'Unban user';
    }
    if(+$(this).attr('is_mute')){
        muteEvent = 'unMuteUser';
        muteTitle = 'Unmute user';
    }
    $('#user-container #ban-user').attr('event',banEvent).html(banTitle);
    $('#user-container #mute-user').attr('event',muteEvent).html(muteTitle);
    $(this).parent().find('li.border').removeClass('border border-primary');
    $(this).addClass('border border-primary');
    if($(this).attr('user_id') == User.id){
        $('#user-container #admin-option .dropdown-menu').children().addClass('disabled');
    }
});

$('#user-container #ban-user').click(function () {
    let id = $('#user-container #list-users li.border').attr('user_id');
    let event = $(this).attr('event');
    if(event in Chat) {
        Chat[event](id);
    }
});

$('#user-container #mute-user').click(function () {
    let id = $('#user-container #list-users li.border').attr('user_id');
    let event = $(this).attr('event');
    if(event in Chat) {
        Chat[event](id);
    }
});
