const WS = new WebSocket("ws://localhost:8090/?token="+User.token);

WS.onopen = function (e) {
    Chat.getOnlineUsersForClient();
    Chat.init();
};
WS.onerror = function (e) {
    console.log(e);
};
WS.onclose = function(e) {
    $('#alert #notify').text('Connection closed');
    $('#alert').modal('show');
};
WS.onmessage = function (e) {
    let data = JSON.parse(e.data);
    if(!data.event) {
        return;
    }
    Chat.event(data.event, data);
};

