function update_lbl_slider(element, value) {
    if (value > 50) {
        value = "more than 50";
    }
    if (value < 5) {
        value="less than 5";
    }
        //If grocery slide changed
    if(element==1){
        var label = $('#lbl_slider_grocery');
        label.text(value);
    }
        //If shopping slide changed
    else if(element==2){
        var label = $('#lbl_slider_shopping');
        label.text(value);
    }
        //If bts slide changed
    else if(element==3){
        var label = $('#lbl_slider_bts');
        label.text(value);
    }
}