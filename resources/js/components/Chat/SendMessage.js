import  React,{Component} from 'react';
// import {Connection} from '../Connection';
// require('../Connection');

class SendMessage extends Component{
    constructor(props){
        super(props);
        this.state ={
            message: ''
        };
        this.onChange = this.onChange.bind(this);
        this.send = this.send.bind(this);
    }

    onChange(e){
        this.setState({message: e.target.value});
    }

    send(){
        console.log(Connection)
        Connection.sendJSON({
            'event': 'onMessage',
            'message': this.state.message
        })
    }

    render(){
        return (
            <div>
                <input value={this.state.message} onChange={this.onChange} maxLength='200' />
                <div>
                    <button onClick={this.send} className='btn btn-success'>Send</button>
                </div>
            </div>
        );
    }
}

export default SendMessage;
