
$(document).ready(function(){

	// Actions on submit
	$("#sign-up-form").on("submit", function(e){
		// Wipe old error
		wipeAllErrorSpots();
		let allCorrect = true;

		// Control that an email has the correct format
		let email = $("#input-email").val();
		if ( !isEmail(email) ) {
			allCorrect = false;
			printErrorMessage("email-error-spot", "Du skrev inte in en mejladress.");
		}

		// Control that there is a password
		let password = $("#input-password").val();
		if ( password.trim() === "" ) {
			allCorrect = false;
			printErrorMessage("password-error-spot", "Ett lösenord måste skrivas in.");
		}


		// If something is wrong
		if ( !allCorrect ) {

			// Prevent submit
			e.preventDefault();

		}


	});


});

// Show a error message
function printErrorMessage(id, message) {
	$("#" + id).text(message);
	$("#" + id).addClass("error-border");
}

// Wipe all the error spots
function wipeAllErrorSpots() {

	wipeErrorSpot("email-error-spot");

	wipeErrorSpot("password-error-spot");

}

// Wipe a error spots
function wipeErrorSpot(id) {

	$("#" + id).text("");
	$("#" + id).removeClass("error-border");

}


