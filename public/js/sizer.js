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
        let h = $(window).height();
        let navH = $('nav').outerHeight();
        let mH = 100 - (navH/h * 100);
        $('main').css('height',mH+'%');
        let cbH = $('#chat-body > .card-body').height();
        $('#chat_output').height(cbH - cbH * .25);
        $('#list-users').height($('#list-users').parent().height() - ($('#list-users').parent().outerHeight() - $('#list-users').parent().height()));
    };
    setSizeChat();
    $(window).resize(function(){
        setSizeChat();
    });

})();
