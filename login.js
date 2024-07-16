$(document).ready(function() {
    $.get("login.php", function(data) {
    });
});

function verifyEmail() {
    var emailInput = document.getElementById("emailInput");
    var email = emailInput.value.trim();
    var notificationContainer = document.getElementById("notificationContainer");
    notificationContainer.innerText = "";

    if (!email.endsWith("@connect.hku.hk")) {

        notificationContainer.innerText = "Please enter a valid HKU @connect email address";
        return;
    }
    $.post("check.php", { checkEmail: true, email: email }, function(data) {
        data = data.trim();

        if (data === "not_exists") {
            notificationContainer.innerText = "Cannot find your email record";
            return;
        }
    }).fail(function() {
        notificationContainer.innerText = "Error checking email. Please try again later.";
    });
}
function verifyEmail_register(){
    var emailInput = document.getElementById("email2");
    var email = emailInput.value.trim();
    var notificationContainer = document.getElementById("notificationContainer");
    notificationContainer.innerText = "";
    if (!email.endsWith("@connect.hku.hk")) {

        notificationContainer.innerText = "Please enter a valid HKU @connect email address";
        return;
    }
    $.post("check.php", { checkEmail: true, email: email }, function(data) {
        data = data.trim();

        if (data === "exists") {
            notificationContainer.innerText = "You have registered before!"
        }
    }).fail(function() {
        notificationContainer.innerText = "Error checking email. Please try again later.";
    });
}