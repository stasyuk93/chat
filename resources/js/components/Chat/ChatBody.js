import React, {Component} from 'react';
import Message from './Message';
import UserColors from '../User/UserColors';

class ChatBody extends Component {

    constructor(props){
        super(props);
        this.state = {
            messages: []
        }
    }

    addMessage(message){
        this.setState(
            prevState => ({
                messages: prevState.messages.concat(message)
            })
        )
    }

    render(){
        const {messages} = this.state;
        return (
           <div className='card-body'>
               {
                   messages.map(message => {
                        const userColor = UserColors.storage[message.user_id];

                        return (
                           <Message message={message} userColor={userColor} />
                        )
                    })
               }
           </div>
        );
    }
}
export default ChatBody;
