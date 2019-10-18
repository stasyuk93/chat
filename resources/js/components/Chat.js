import React from "react";
import IO from 'socket.io-client';
import cookie from 'react-cookies';
import Login from './Login';


class Chat extends React.Component{
    constructor(props){
        super(props);

        this.state = {
            message: '',
            messages: []
        };

        this.connect = this.connect.bind(this);

        const token = cookie.load('token');

        if(token){
            this.state.token = token;
            this.connect(token);
        } else {
            this.state.token = false;
        }

        this.sendMessage = this.sendMessage.bind(this);




    }

    connect(token){
        const addMessage = data => {
            this.setState({messages: [...this.state.messages, data]});
        };

        this.socket = IO('localhost:8090?token='+token);

        this.socket.on('RECEIVE_MESSAGE', function(data){
            console.log(data);

            addMessage(data);
        });

        this.socket.on('disconnect', function () {
            console.log('ondisconnect');
        });
    }

    sendMessage(event){
        event.preventDefault();
        this.socket.emit('SEND_MESSAGE', {
            author: this.state.username,
            text: this.state.message
        });
        this.setState({message: ''});
    }

    render(){
        if(this.state.token === false){
            return (
                <Login connect={this.connect}/>
            )
        }
        return (
            <div className="container">
                <div className="row">
                    <div className="col-12">
                        <div className="card">
                            <div className="card-body">
                                <div className="card-title">Chat</div>
                                <hr/>
                                <div className="messages">
                                    {this.state.messages.map((message, index) => {
                                        return (
                                            <div key={index}>{message.author}: {message.text}</div>
                                        )
                                    })}
                                </div>
                                <div className="footer">
                                    <input type="text" placeholder="Message" className="form-control" value={this.state.message} onChange={ev => this.setState({message: ev.target.value})}/>
                                    <button onClick={this.sendMessage} className="btn btn-primary form-control mt-2">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Chat;
