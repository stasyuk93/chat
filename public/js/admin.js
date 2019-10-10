Chat.getAllUsers = function (WS) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'getAllUsers'
            })
        );
    }
};

Chat.showAllUsers = function(data){
    this.renderUserList(data)
};

Chat.banUser = function (WS, user_id) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'banUser',
                'user_id': user_id
            })
        );
    }
};

Chat.unBanUser = function (WS,user_id) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'unBanUser',
                'user_id': user_id
            })
        );
    }
};

Chat.muteUser = function (WS, user_id) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'muteUser',
                'user_id': user_id
            })
        );
    }
};

Chat.unMuteUser = function (WS, user_id) {
    if(WS instanceof WebSocket){
        WS.send(
            JSON.stringify({
                'event': 'unMuteUser',
                'user_id': user_id
            })
        );
    }
};

$('#user-container #show-all-users').click(function(){
    Chat.getAllUsers(WS);
});
