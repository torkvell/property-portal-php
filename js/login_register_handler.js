function login_register_handler(buttonElement) {
    var buttonClickedId = buttonElement.id;
    if (buttonClickedId === 'login_btn') {
        //Do login stuff//

        //We clear the content for user output
        $("#result_login").html("");

        // Variable to hold request
        var request;

        // Bind to the submit event of our form
        $("#login_form").submit(function (event) {

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

            // Fire off the request to /login.php
            request = $.ajax({
                url: "login.php",
                type: "post",
                data: serializedData,
                success: function (response) {
                    if (response == "success") {
                        // If login attempt is success: redirect user to profile page
                        window.location.replace("https://toralf-fullstack.no/user_main_page.php")
                    } else {
                        // User output
                        $("#result_login").append("<h4 style='color:red;'>" + response + "</h4>");
                    }
                }
            });

            // Callback handler that will be called on failure
            //request.fail(function (jqXHR, textStatus, errorThrown) {
            //    // Log the error to the console               
            //    alert(
            //        "The following error occurred: " +
            //        textStatus, errorThrown
            //    );
            //});

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // Reenable the inputs
                $inputs.prop("disabled", false);
                // Unbind to the submit event of our form to prevent multiple js calls to submit event
                $("#login_form").unbind('submit');
            });

        });
    }
    if (buttonClickedId === 'register_btn') {
        //We clear the content for user output
        $("#result_register").html("");

        // Variable to hold request
        var request;

        // Unbind to the submit event of our form to prevent multiple js calls to submit event
        $("#register_form").unbind('submit');
        // Bind to the submit event of our form
        $("#register_form").submit(function (event) {
            // Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            // Abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $('#register_form');

            // Let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");

            // Serialize the data in the form
            var serializedData = $form.serialize();
            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.
            $inputs.prop("disabled", true);

            // Fire off the request to /login.php
            request = $.ajax({
                url: "register.php",
                type: "post",
                data: serializedData,
                success: function (response) {
                    if (response == "success") {
                        // If login attempt is success: redirect user to profile page
                        window.location.replace("https://toralf-fullstack.no/user_main_page.php")
                    } else {
                        // User output
                        $("#result_register").append("<h4 style='color:red;'>" + response + "</h4>");
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