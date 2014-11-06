/**
 * Created by Alexis on 05/11/2014.
 */

$(document).ready(function () {
    $("#loginButton").click(function(){
        $("#internAuthForm").submit();
    });

    $("#resetButton").click(function() {
        $("#internAuthForm")[0].reset();
    });
});