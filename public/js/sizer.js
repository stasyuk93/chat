function showUsers(e){
    $('#user-container').removeClass('d-none');
    $('#chat-container').hide();
    $(e).parents('div.toggles').children().removeClass('hide');
    $(e).parent().addClass('hide');
    $('#list-users').height($('#list-users').parent().height() - ($('#list-users').parent().outerHeight() - $('#list-users').parent().height()));

}

function showChat(e){
    $('#user-container').addClass('d-none');
    $('#chat-container').show();
    $(e).parents('div.toggles').children().removeClass('hide');
    $(e).parent().addClass('hide');
    $('#list-users').height($('#list-users').parent().height() - ($('#list-users').parent().outerHeight() - $('#list-users').parent().height()));

}
(()=>{
    function setSizeChat()
    {
        let height = $(window).height();
        let navHeight = $('nav').outerHeight();
        let mainHeight = 100 - (navHeight/height * 100);
        $('main').css('height',mainHeight+'%');
        let chatBodyHeight = $('#chat-body > .card-body').height();
        let inputHeight = $('#chat_input').parent().outerHeight();
        let chatOutputHeight = chatBodyHeight - inputHeight - 50;
        $('#chat_output').height(chatOutputHeight);
        $('#list-users').height($('#list-users').parent().height() - ($('#list-users').parent().outerHeight() - $('#list-users').parent().height()));
    };
    setSizeChat();
    $(window).resize(function(){
        setSizeChat();
    });

})();
