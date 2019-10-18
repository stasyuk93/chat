import React from 'react';


const Message = (props) => {
    const textColor = props.UserColor.message;
    const nameColor = props.UserColor.name;
    const name = props.message.name;
    const message = props.message.message;

    return (
        <div className='border-bottom border-secondary'>
            <h4 style={nameColor}>
                {name}
            </h4>
            <p style={textColor}>
                {message}
            </p>
        </div>
    );
};

export default Message;
