
$(document).ready(function() {
	$("#subscribe-form").on("submit", function(e) {
		e.preventDefault();
		submitEmail();
	});
	$("#subscribe-form-email").on("focus", function(e) {
		restoreEmailError();
	});
	$("#subscribe-form-email").on("blur", function(e) {

		var email = $("#subscribe-form-email").val();

		if ( email.trim() != "" && !isEmail(email) ) {
			paintEmailError();
		}
		else {
			restoreEmailError();
		}

	});
});

function paintEmailError() {
	$("#subscribe-form-email").addClass("email-error");
}
function restoreEmailError() {
	$("#subscribe-form-email").removeClass("email-error");
	$("#subscribe-error-spot").removeClass("error-border");
	$("#subscribe-error-spot").text("");
	$("#subscribe-loading").hide();
}

async function submitEmail() {

	var email = $("#subscribe-form-email").val();

	if ( isEmail(email) ) {

		try {
			restoreEmailError();
			$("#subscribe-form input").hide();
			$("#subscribe-form button").hide();
			$("#subscribe-loading").show();
			await addSubscriber(email, footerPath);

			$("#subscribe-result").fadeIn(500);
			$("#subscribe-loading").hide();
		}
		catch (error) {
			restoreEmailError();
			$("#subscribe-form input").show();
			$("#subscribe-form button").show();
			$("#subscribe-error-spot").addClass("error-border");
			$("#subscribe-error-spot").text("Du är redan prenumererad med den epost adressen!");
			paintEmailError();
		}

	}
	
}
