$(document).ready(function () {
    /* code here */
    $("#search_box_extension").hide();
    $("#search_box_extension").unbind();
});


function update_rent_div() {
    $("#for_rent_div").css("background", "rgba(0, 0, 0, 0.82)");
    $("#for_sale_div").css("background", "#6a67ce");
    $("#rent_rules_div").show();
    $("#rent_rules_div").unbind();
}
function update_sale_div(){
    $("#for_sale_div").css("background", "rgba(0, 0, 0, 0.82)");
    $("#for_rent_div").css("background", "#6a67ce");
    $("#rent_rules_div").hide();
    $("#rent_rules_div").unbind();
}
function update_area_list(city) {
    //This is made temporarily just for testing - AJAX request needs to be made to script and return values to area drop down list
    if (city == 'Oslo') {
        $("#area_div").show();
        $("#area_div").unbind();
        $("#outer_bts_div").show();
        $("#outer_bts_div").unbind();
    } else {
        $("#area_div").hide();
        $("#area_div").unbind();
        $("#outer_bts_div").hide();
        $("#outer_bts_div").unbind();
    }
}
function showfilters() {
    $("#search_box_extension").show();
    $("#search_box_extension").unbind();
    $("#show_more_filters_btn").hide();
    $("#show_more_filters_btn").unbind();
}
function hidefilters() {
    $("#search_box_extension").hide();
    $("#search_box_extension").unbind();
    $("#show_more_filters_btn").show();
    $("#show_more_filters_btn").unbind();
}


$(function () {
    //Price slider
    $("#price_slider").slider({
        range: true,
        min: 0,
        max: 500000,
        values: [0, 500000],
        slide: function (event, ui) {
            $("#amount_price").val(ui.values[0] + " $" + " - " + ui.values[1] + " $");
        }
    });
    $("#amount_price").val($("#price_slider").slider("values", 0) + " $" +
      " - " + $("#price_slider").slider("values", 1) + " $");
    //Grocery store range slider
    $("#grocery_store_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#amount_grocery").val(ui.values[0] + " min" + " - " + ui.values[1] + " min");
        }
    });
    $("#amount_grocery").val($("#grocery_store_slider").slider("values", 0) + " min" +
      " - " + $("#grocery_store_slider").slider("values", 1) + " min");
    //Shopping mall range slider
    $("#shopping_mall_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#amount_shopping").val(ui.values[0] + " min" + " - " + ui.values[1] + " min");
        }
    });
    $("#amount_shopping").val($("#shopping_mall_slider").slider("values", 0) + " min" +
      " - " + $("#shopping_mall_slider").slider("values", 1) + " min");
    //BTS/MRT range slider
    $("#bts_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#amount_bts").val(ui.values[0] + " min" + " - " + ui.values[1] + " min");
        }
    });
    $("#amount_bts").val($("#bts_slider").slider("values", 0) + " min" +
      " - " + $("#bts_slider").slider("values", 1) + " min");
    //Sqm slider
    $("#sqm_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#amount_sqm").val(ui.values[0] + " min" + " - " + ui.values[1] + " min");
        }
    });
    $("#amount_sqm").val($("#sqm_slider").slider("values", 0) + " min" +
      " - " + $("#sqm_slider").slider("values", 1) + " min");
});