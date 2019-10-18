import React from 'react';
import {render} from 'react-dom';
//
//
// const App = () =>{
//     return (
//         <div>
//             <ChatBody/>
//             <SendMessage/>
//         </div>
//     )
// };

import Chat from './Chat';

render(
    <Chat/>, document.getElementById('app')
);
