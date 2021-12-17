
$(document).ready(function(){

	// Show correct input field
	$("#answertype-email").on("click", function(e){
		$("#answer-email").show();
		$("#answer-phone").hide();
		$("#answer-letter").hide();
	});
	$("#answertype-phone").on("click", function(e){
		$("#answer-email").hide();
		$("#answer-phone").show();
		$("#answer-letter").hide();
	});
	$("#answertype-letter").on("click", function(e){
		$("#answer-email").hide();
		$("#answer-phone").hide();
		$("#answer-letter").show();
	});
	$("#answertype-none").on("click", function(e){
		$("#answer-email").hide();
		$("#answer-phone").hide();
		$("#answer-letter").hide();
	});

	// Actions on submit
	$("#contact-form").on("submit", async function(e){
		// Prevent normal submit
		e.preventDefault();
		// Wipe old error
		wipeAllErrorSpots();
		var allCorrect = true;

		// Control that the names are in correct format
		var firstname = $("#input-firstname").val().trim();
		var lastname = $("#input-lastname").val().trim();

		if ( !isName(firstname) ) {
			allCorrect = false;
			printErrorMessage("firstname-error-spot", "Endast alfabetiska bokstäver.")
		}
		if ( !isName(lastname) ) {
			allCorrect = false;
			printErrorMessage("lastname-error-spot", "Endast alfabetiska bokstäver.");
		}

		var email = "";
		var phone = "";
		var adress = "";
		var zip = "";

		var isOptionEmail = false;
		var isOptionPhone = false;
		var isOptionLetter = false;

		// Get what type of answertype was selected
		var answertypeExsists = $("#answertype-email").is(':checked') || $("#answertype-phone").is(':checked') || $("#answertype-letter").is(':checked');
		if ( answertypeExsists ) {

			if ( $("#answertype-email").is(':checked') ) {

				email = $("#input-email").val().trim();

				if ( !isEmail(email) ) {
					allCorrect = false;
					printErrorMessage("answer-email-error-spot", "Ange en giltig emailadress.");
				}

				isOptionEmail = true;

			}
			else if ( $("#answertype-phone").is(':checked') ) {

				phone = $("#input-phone").val().trim();

				if ( !isPhoneNumber(phone) ) {
					allCorrect = false;
					printErrorMessage("answer-phone-error-spot", "Ange ett giltigt telefonnummer.");
				}

				isOptionPhone = true;

			}
			else if ( $("#answertype-letter").is(':checked') ) {

				adress = $("#input-address").val().trim();
				zip = $("#input-zip").val().trim();

				if ( adress.trim() == "" ) {
					allCorrect = false;
					printErrorMessage("answer-address-error-spot", "En address måste anges.");
				}
				if ( !isOnlyNumbers(zip) || zip.length != 5 ) {
					allCorrect = false;
					printErrorMessage("answer-zip-error-spot", "Ange ett giltigt postnummer.");
				}

				isOptionLetter = true;

			}

		}

		// Control so that a message has been entered
		var message = $("#input-message").val().trim();

		if ( message.trim() == "" ) {
			allCorrect = false;
			printErrorMessage("message-error-spot", "Ett meddelande måste skrivas.");
		}


		// Show that message has been sent
		if ( allCorrect ) {

			try {
				let result;
				if ( isOptionEmail ) {
					result = await doContactEmailRespond(firstname, lastname, message, email, "../");
				}
				else if ( isOptionPhone ) {
					result = await doContactPhoneRespond(firstname, lastname, message, phone, "../");
				}
				else if ( isOptionLetter ) {
					result = await doContactLetterRespond(firstname, lastname, message, adress, zip, "../");
				}
				else {
					result = await doContactNoRespond(firstname, lastname, message, "../");
				}
				$("#answer-content").fadeIn(1000);

			}
			catch ( error ) {
				console.log(error);
				$("#error-content").fadeIn(1000);
			}

			$("#form-content").hide();
			$(document).scrollTop( $("#answer-content").offset().top - $("#contact-container").height()/2 );


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

	wipeErrorSpot("firstname-error-spot");
	wipeErrorSpot("lastname-error-spot");

	wipeErrorSpot("answertype-error-spot");

	wipeErrorSpot("answer-email-error-spot");

	wipeErrorSpot("answer-phone-error-spot");

	wipeErrorSpot("answer-address-error-spot");

	wipeErrorSpot("answer-zip-error-spot");

	wipeErrorSpot("message-error-spot");

}

// Wipe a error spots
function wipeErrorSpot(id) {

	$("#" + id).text("");
	$("#" + id).removeClass("error-border");

}


