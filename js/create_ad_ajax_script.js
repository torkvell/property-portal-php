function create_ad_ajax_script(buttonElement) {
    var buttonClickedId = buttonElement.id;
    if (buttonClickedId === 'create_ad_btn') {

        //We clear the content for user output
        $("#ajax_feedback").html("");

        // Variable to hold request
        var request;

        // Unbind to the submit event of our form to prevent multiple js calls on next submit event
        $("#create_ad_form").unbind('submit');

        // Bind to the submit event of our form
        $("#create_ad_form").submit(function (event) {

            //// Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            // Abort any pending request
            if (request) {
                request.abort();
            }
           
            //We cant serialize files so we use formData instead
            var form_data = new FormData($('#create_ad_form')[0]);

            ////// Let's disable the inputs for the duration of the Ajax request.
            //$inputs.prop("disabled", true);

            // Fire off the request to /update_profile.php
            request = $.ajax({
                url: "create_ad_server_script.php",
                type: "post",
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if (response == "success") {
                        // If update attempt is success:
                        $("#ajax_feedback").append("<h4 style='color:green;'>Ad created succesfully!</h4>");
                        window.location.replace("https://toralf-fullstack.no/my_ads.php");
                    } else {
                        // User output
                        $("#ajax_feedback").append("<h4 style='color:red;'>" + response + '</h4>');
                    }
                }
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