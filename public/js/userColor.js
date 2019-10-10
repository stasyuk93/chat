const UsersColor = {storage:{}};

let background = $('#chat-body').css('background-color');

UsersColor.add = function (id) {
    if(!(id in this.storage)){
        UsersColor.storage[id] = {
            name: this.getRandomColor(background),
            message: this.getRandomColor(background)
        }
    }
};

UsersColor.convertHex = function (hex){
    hex = hex.replace('#','');
    r = parseInt(hex.substring(0,2), 16);
    g = parseInt(hex.substring(2,4), 16);
    b = parseInt(hex.substring(4,6), 16);

    return'rgb('+r+','+g+','+b+')';
};

UsersColor.getRandomColor = function (rgb) {
    let background = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

    let rgbValue = [];

    for(let i = 0; i < 3;){
        let color = Math.round(Math.random() * 255);
        if(Math.abs(Math.floor((background[i + 1] - color))) > 20){
            rgbValue[i] = color;
            i++;
        }
    }

    return 'rgb(' + rgbValue[0] + ', ' + rgbValue[1] + ', ' + rgbValue[2] + ')';
};

UsersColor.setRandomColor = function (selector, background = 'rgb(255,255,255)') {
    let textColor = this.getRandomColor(background);
    $(selector).css('color', textColor);
    return textColor;
};


UsersColor.add(User.id);

$('#chat_output').children().each(function(){
    let id = $(this).attr('user_id');
    UsersColor.add(id);
});

for(let id in UsersColor.storage){
    $('#chat_output [user_id='+id+']').each(function () {
        $(this).children('.user-name').css('color', UsersColor.storage[id].name);
        $(this).children('.message').css('color', UsersColor.storage[id].message);
    });

}



