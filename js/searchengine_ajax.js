function submit_searchengine(buttonElement) {
    var buttonClickedId = buttonElement.id;
    if (buttonClickedId === 'submit_searchengine_btn') {

        //We clear the content for user output
        $("#ajax_feedback").html("");
        $('#outer_ad_box_div').html("");
        // Variable to hold request
        var request;

        // Unbind to the submit event of our form to prevent multiple js calls to submit event
        $("#searchengine_form").unbind('submit');
        // Bind to the submit event of our form
        $("#searchengine_form").submit(function (event) {

            // Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            // Abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $(this);

            // Let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");

            // Serialize the data in the form
            var serializedData = $form.serialize();
            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.
            $inputs.prop("disabled", true);

            // Fire off the request to /update_profile.php
            request = $.ajax({
                url: "search_ads_script.php",
                type: "post",
                data: serializedData,
                success: function (response) {
                    var str = response;
                    if (str.indexOf('picture_box') > -1) {
                        $('#outer_ad_box_div').html(response);
                    } else {
                        $('#ajax_feedback_top').html(response);//This element is used to dispaly error msg to user
                        $('#ajax_feedback_bottom').html(response);//This element is used to dispaly error msg to user
                    }
                }
            });

             //Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown) {
                // Log the error to the console               
                alert("The following error occurred: " +textStatus, errorThrown);
            });

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
            });

        });
    }
}