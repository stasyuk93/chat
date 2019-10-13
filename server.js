
var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
    res.sendFile(__dirname + '/public/index.html');
});

io.on('connection', function(socket){
    console.log('a user connected');
    console.log(socket.handshake.query.token);
    socket.on('chat message', function(msg){
        io.emit('chat message', msg);
        // io.emit('chat message', socket);

    });
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
    // socket.disconnect(true);

});
// io.on('close',function (data) {
//     console.log(data);
// });

// io.ondisconnect(function (data) {
//     console.log(data);
// });


http.listen(3000, function(){
    console.log('listening on *:3000');
});

// let app = require('express')(),
//     server = require('http').createServer(app),
//     io = require('socket.io')(server),
//     axios = require('axios'),
//     config = require('./config');
//
// const API_URL = config.apiUrl;
//
// app.use(function(req, res, next) {
//     res.header('Access-Control-Allow-Origin', '*');
//     res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
//     next();
// });
//
// io.on('connection', function (socket) {
//     socket.on('join', (data) => {
//         const token = data.token;
//         const chatSocketId = data.chatSocketId;
//         const type = data.type;
//         const additional = data.additional;
//
//         axios
//             .post(
//                 ${API_URL}/api/chat/create-chat, {type, additional},
//             {
//                 headers: {
//                     'Authorization': Bearer ${token},
//                 }
//             }
//     )
//     .then((res) => {
//             if(res.data.id) {
//                 socket.join(chatSocketId);
//
//                 axios
//                     .post(
//                         ${API_URL}/api/chat/connection-event/${res.data.id}, {isConnected: 1},
//                     {
//                         headers: {
//                             'Authorization': Bearer ${token},
//                         }
//                     }
//             )
//             .then(() => {})
//                     .catch((err) => {
//                         console.log('err -------', err.response.data);
//                         console.log('status code -------', err.response.status);
//                     });
//             }
//         })
//             .catch(err => {
//                 if(err.response.status >= 400) {
//                     console.log('err -------', err.response.data);
//                     console.log('status code -------', err.response.status);
//                 }
//             });
//     });
//
//     socket.on('message', function (data) {
//         const {chatSocketId, text, token, chatDataBaseId} = data;
//         socket.join(chatSocketId);
//
//         axios
//             .post(
//                 ${API_URL}/api/chat/send-message/${chatDataBaseId},
//             {
//                 text,
//             },
//             {
//                 headers: {
//                     'Authorization': Bearer ${token},
//                     'Content-Type': 'application/json',
//                 }
//             }
//     )
//     .then((res) => {
//             socket.join(chatSocketId);
//             io.to(chatSocketId).emit('message', res.data);
//         })
//             .catch((err) => {
//                 console.log('message log',  err.response.data);
//                 console.log('error status',  err.response.status);
//
//                 socket.join(chatSocketId);
//                 io.to(chatSocketId).emit('loggerErrors', {errorResponse: err.response.data});
//             });
//     });
//
//     socket.on('leave', (data) => {
//         const {token, chatDataBaseId, chatSocketId} = data;
//
//         axios
//             .post(
//                 ${API_URL}/api/chat/connection-event/${chatDataBaseId}, {isConnected: 0},
//             {
//                 headers: {
//                     'Authorization': Bearer ${token},
//                 }
//             }
//     )
//     .then(() => {
//             console.log('success leave');
//         })
//             .catch(() => {
//                 console.log('catch leave');
//             });
//     });
//
//     socket.on('disconnect', () => {});
// });
//
// app.get('*', function (req, res) {
//     res.sendFile(__dirname + '/public/index.html');
// });
//
// server.listen(3000, function () {
//     console.log('listening on *:3000/');
// });

