
$(document).ready(function () {
    $(function() {
        var timeout = 3000;
        $('.alert').delay(timeout).fadeOut(300);
    });

    $.validator.addMethod("noSpaces", function(value, element) {
        return value.indexOf(" ") === -1; // Returns true if there are no spaces
    }, "This field should not contain spaces.");
});

