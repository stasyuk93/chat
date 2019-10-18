import React from 'react';


const Header = (props) => {
    const title = props.title;
    const onlineUsers = props.onlineUsers;
    return (
        <div className='card-header justify-content-between'>
            <span>{title}</span>
            <span>{onlineUsers}</span>
        </div>
    )
};

export default Header
