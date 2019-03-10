function elementSupportsAttribute(element, attribute) {
    var test = document.createElement(element);
    if (attribute in test) {
        return true;
    }
    else {
        return false;
    }
}
function fallback() {
    if (!elementSupportsAttribute('input', 'placeholder')) {
        alert("Please update your browser to a newer version to make full use of this website. Error: Placeholder is not supported by browser.");
        //TODO: Replace placeholder with something else
            //var all = document.getElementsByClassName("placeholder");
            //for (i = 0; i < all.length; i++) {
            //    var temp = all[i];
            //    //var $label = $("<label>").text('Testlabel:');
            //    //$('placeholder').append($label);
            //    if ($(temp).attr('placeholder') == "First Name*") {
            //        alert("placeholder=First name is true");
            //        temp.value = "First Name*";
            //    } else if (temp.placeholder == "Password") {
            //        temp.value = "Password";
            //    }
            //}
    }
        if (!elementSupportsAttribute('input', 'required')) {
            alert("Please update your browser to a newer version to make full use of this website. Error: Required is not supported by browser.");
            //TODO: Give error message if required input fields are empty
                //function findAllRequired() {
                //    var all = document.getElementsByClassName("required");
                //    alert(all.length); //hvor mange i klassen
                //    for (i = 0; i < all.length; i++) {
                //        var temp = all[i];
                //        if (temp.value == "") {
                //            alert(temp.name + " er ikke utfylt");
                //            temp.classList.add("fallback_error");
                //        }
                //        else {
                //            temp.classList.remove("fallback_error");
                //        }//slutt feilhåndtering
                //    }//slutt for
                //}//slutt function
        }
    }