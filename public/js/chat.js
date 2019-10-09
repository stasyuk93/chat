    let UsersColor = {};

    UsersColor.add = function (id) {
        if(!(id in this)){
            UsersColor[id] = {
                name: getRandomColor(background),
                message: getRandomColor(background)
            }
        }
    };

    function convertHex(hex){
        hex = hex.replace('#','');
        r = parseInt(hex.substring(0,2), 16);
        g = parseInt(hex.substring(2,4), 16);
        b = parseInt(hex.substring(4,6), 16);

        return'rgb('+r+','+g+','+b+')';
    }

    function getRandomColor(rgb) {
        let background = rgb.match(/^rgb\((\d+), \s*(\d+), \s*(\d+)\)$/);

        let rgbValue = [];

        rgbValue[0] = Math.round(Math.random() * 255);
        rgbValue[1] = Math.round(Math.random() * 255);
        rgbValue[2] = Math.round(Math.random() * 255);

        let rV = Math.floor((background[1] - rgbValue[0]));
        let gV = Math.floor((background[2] - rgbValue[1]));
        let bV = Math.floor((background[3] - rgbValue[2]));
        return 'rgb(' + rV + ', ' + gV + ', ' + bV + ')';
    }

    function setRandomColor(selector, background = 'rgb(255,255,255)') {
        let textColor = getRandomColor(background);
        $(selector).css('color', textColor);
        return textColor;
    }


    let background = $('#chat-body').css('background-color');


    $('#chat_output').children().each(function(){
        let id = $(this).attr('user_id');
        UsersColor.add(id);
    });

    for(let id in UsersColor){
        $('#chat_output [user_id='+id+']').each(function () {
            $(this).children('.user-name').css('color', UsersColor[id].name);
            $(this).children('.message').css('color', UsersColor[id].message);
        });

    }



