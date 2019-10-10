const WS = new WebSocket("ws://localhost:8090/?token="+User.token);

WS.onopen = function (e) {
    console.log(e);
    Chat.getOnlineUsersForClient(this);
    // Bind onkeyup event after connection
    Chat.sendMessage(this);
};
WS.onerror = function (e) {
    console.log(e);

    // Error handling
    console.log(e);
};
WS.onclose = function(e) {
    console.log(e);

    // Chat.close(this);
};
WS.onmessage = function (e) {
    console.log(e);

    let data = JSON.parse(e.data);
    Chat.event(data.event, data);
};

