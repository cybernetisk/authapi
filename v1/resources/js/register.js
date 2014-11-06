/**
 * Created by Alexis on 05/11/2014.
 */

$(document).ready(function () {
    $("#registerButton").click(function(){
        $("#registerForm").submit();
    });

    $("#resetButton").click(function() {
        $("#registerForm")[0].reset();
    });
});
