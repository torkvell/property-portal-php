$(document).ready(function () {
    /* code here */
    $("#search_box_extension").hide();
    $("#search_box_extension").unbind();    
});
$(function () {
    //Price slider
    $("#price_slider").slider({
        range: true,
        min: 0,
        max: 500000,
        values: [0, 500000],
        slide: function (event, ui) {
            $("#price_min").val(ui.values[0] + " $");
            $("#price_max").val(ui.values[1] + " $");
        }
    });
    $("#price_min").val($("#price_slider").slider("values", 0) + " $");
    $("#price_max").val($("#price_slider").slider("values", 1) + " $");
    //Grocery store range slider
    $("#grocery_store_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#distance_grocery_min").val(ui.values[0] + " min");
            $("#distance_grocery_max").val(ui.values[1] + " min");
            if (ui.values[0] > 50) {
                $("#distance_grocery_min").val("more than 50 min");
            }
            if (ui.values[1] > 50) {
                $("#distance_grocery_max").val("more than 50 min");
            }
        }
    });
    $("#distance_grocery_min").val($("#grocery_store_slider").slider("values", 0) + " min");
    $("#distance_grocery_max").val($("#grocery_store_slider").slider("values", 1) + " min");
    if (($("#grocery_store_slider").slider("values", 1) > 50)) {
        $("#distance_grocery_max").val("more than 50 min");
    };
    //Shopping mall range slider
    $("#shopping_mall_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#distance_shopping_min").val(ui.values[0] + " min");
            $("#distance_shopping_max").val(ui.values[1] + " min");
            if (ui.values[0] > 50) {
                $("#distance_shopping_min").val("more than 50 min");
            }
            if (ui.values[1] > 50) {
                $("#distance_shopping_max").val("more than 50 min");
            }
        }
    });
    $("#distance_shopping_min").val($("#shopping_mall_slider").slider("values", 0) + " min");
    $("#distance_shopping_max").val($("#shopping_mall_slider").slider("values", 1) + " min");
    if (($("#shopping_mall_slider").slider("values", 1) > 50)) {
        $("#distance_shopping_max").val("more than 50 min");
    };
    //BTS/MRT range slider
    $("#bts_slider").slider({
        range: true,
        min: 0,
        max: 51,
        values: [0, 51],
        slide: function (event, ui) {
            $("#distance_bts_min").val(ui.values[0] + " min");
            $("#distance_bts_max").val(ui.values[1] + " min");
            if (ui.values[0] > 50) {
                $("#distance_bts_min").val("more than 50 min");
            }
            if (ui.values[1] > 50) {
                $("#distance_bts_max").val("more than 50 min");
            }
        }
    });
    $("#distance_bts_min").val($("#bts_slider").slider("values", 0) + " min");
    $("#distance_bts_max").val($("#bts_slider").slider("values", 1) + " min");
    if (($("#bts_slider").slider("values", 1) > 50)) {
        $("#distance_bts_max").val("more than 50 min");
    };
    //Size slider
    $("#size_slider").slider({
        range: true,
        min: 0,
        max: 301,
        values: [0, 301],
        slide: function (event, ui) {
            $("#size_min").val(ui.values[0]);
            $("#size_max").val(ui.values[1]);
            if (ui.values[0] > 300) {
                $("#size_min").val("All");
            }
            if (ui.values[1] > 300) {
                $("#size_max").val("All");
            }
        }
    });
    $("#size_min").val($("#size_slider").slider("values", 0));
    $("#size_max").val($("#size_slider").slider("values", 1));
    if (($("#size_slider").slider("values", 1) > 300)) {
        $("#size_max").val("All");
    };
});

function update_rent_div() {
    $("#for_rent_div").css("background", "rgba(0, 0, 0, 0.82)");
    $("#for_sale_div").css("background", "#6a67ce");
    $("#rent_rules_div").show();
    $("#rent_rules_div").unbind();
    //Update input value for rent and sale on button click
    $("#for_rent_input").val("true");
    $("#for_sale_input").val("false");
    $('#outer_ad_box_div').html("");
    $("#submit_searchengine_btn").click();
}
function update_sale_div(){
    $("#for_sale_div").css("background", "rgba(0, 0, 0, 0.82)");
    $("#for_rent_div").css("background", "#6a67ce");
    //TODO: Remove checked content of renting rules
    $("#rent_rules_div").hide();
    $("#rent_rules_div").unbind();
    //Update input value for rent and sale on button click
    $("#for_rent_input").val("false");
    $("#for_sale_input").val("true");
    $('#outer_ad_box_div').html("");
    $("#submit_searchengine_btn").click();
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
    $("#submit_searchengine_btn").hide();
    $("#submit_searchengine_btn").unbind();
    $("#show_more_filters_btn").hide();
    $("#show_more_filters_btn").unbind();
    $("#ajax_feedback_top").hide();
    $("#ajax_feedback_top").unbind();
}
function hidefilters() {
    $("#search_box_extension").hide();
    $("#search_box_extension").unbind();    
    $("#submit_searchengine_btn").show();
    $("#submit_searchengine_btn").unbind();
    $("#show_more_filters_btn").show();
    $("#show_more_filters_btn").unbind();
    $("#ajax_feedback_top").show();
    $("#ajax_feedback_top").unbind();
}

