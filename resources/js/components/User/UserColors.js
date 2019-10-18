const UserColors = {
    storage:{},

    addUserColor: (userId) => {
        const colors = {
            name: {
                color:this.getRandomColor(background)
            },
            message: {
                color: this.getRandomColor(background)
            }
        };

        this.storage[userId] = colors;

    },

    getRandomColor: (rgb) => {
        const background = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

        const rgbValue = [];

        for(let i = 0; i < 3;){
            let color = Math.round(Math.random() * 255);
            if(Math.abs(Math.floor((background[i + 1] - color))) > 20){
                rgbValue[i] = color;
                i++;
            }
        }

        return 'rgb(' + rgbValue[0] + ', ' + rgbValue[1] + ', ' + rgbValue[2] + ')';
    }

};

export default UserColors;
