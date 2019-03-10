function update_area_list(city) {
    //This is made temporarily just for testing - AJAX request needs to be made to script and return values to area drop down list
    if(city=='Oslo'){
        $("#outer_area_div").show();
        $("#outer_area_div").unbind();
        $("#outer_bts_div").show();
        $("#outer_bts_div").unbind();
    } else {
        $("#outer_area_div").hide();
        $("#outer_area_div").unbind();
        $("#outer_bts_div").hide();
        $("#outer_bts_div").unbind();
    }
}
function update_lbl_slider(element, value) {
    if (value > 50) {
        value = "more than 50";
    }
    if (value < 5 && value >0) {
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
function hide_rent_div() {
    var div = $("#renting_rule_hide_show_div");
    $(div).hide();
    $("#ad_type_for_sale").unbind();
};
function show_rent_div() {
    var div = $("#renting_rule_hide_show_div");
    $(div).show();
    $("#ad_type_for_rent").unbind();
};