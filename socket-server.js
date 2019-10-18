const Express = require('express');
const Socket = require('socket.io');
const axios = require('axios');


const App = Express();

const Server = App.listen(8090, function(){
    console.log('server is running on port 8090')
});

const IO = Socket(Server);

const API_URL = 'http://chat.loc/api/';

IO.on('connection', (socket) => {

    if(socket.handshake.query.token === undefined || socket.handshake.query.token === '') {
        return socket.conn.close();
    }

    const token = socket.handshake.query.token;


    axios.get(
        API_URL + 'user',
        {
            params:{
                token:token
            }
        }
    ).then( response => {
        socket.client.user = response.data;
    }).catch(e => {
        console.log(e.response.data);
        socket.conn.close();
    });


    socket.on('SEND_MESSAGE', function(data){
        axios.post(
            API_URL + 'message',
            {
                token:token,
                text:data.text
            }
        ).then((response) => {
            IO.emit('RECEIVE_MESSAGE', response.data);
        }).catch(e => {
            console.log(e.response.data);
            // socket.conn.close();
        });
    });

});
