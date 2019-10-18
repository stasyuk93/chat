const Connection = new WebSocket('ws://localhost:8090');

Connection.onopen = function (e) {
    console.log(e);

};
Connection.onerror = function (e) {
    console.log(e);
};
Connection.onclose = function(e) {
    console.log(e);

};
Connection.onmessage = function (e) {
    const data = JSON.parse(e.data);
    console.log(data);
};

Connection.sendJSON = function (data) {
    this.send(JSON.stringify(data));
};

export default Connection;
