
$(document).ready(function(){

	// On submit, show update settings text
	$("#other-settings").on("submit", function(e){
		// Prevent form from submitting
		e.preventDefault();

		// Get notification recommended
		let notificationRecommended = $("#input-notrec:checked").val();
		let notificationUpcoming = $("#input-notcom:checked").val();
		let paymentSave = $("#input-savemethod:checked").val();

		// Send the AJAX request
		updateSettingInformation( (notificationRecommended ? true : false), (notificationUpcoming ? true : false), (paymentSave ? true : false) );

		// Show the confirmation text
		$("#other-settings-confirmation").fadeIn(1000);

	});
	$("#account-settings").on("submit", function(e){
		// Prevent form from submitting
		e.preventDefault();

		// Wipe old error
		wipeAllErrorSpots();
		let allCorrect = true;

		let firstname = $("#input-firstname").val();
		let lastname = $("#input-lastname").val();
		let email = $("#input-email").val();

		if ( !isName(firstname) ) {
			allCorrect = false;
			printErrorMessage("firstname-error-spot", "Endast alfabetiska bokstäver.");
		}

		if ( !isName(lastname) ) {
			allCorrect = false;
			printErrorMessage("lastname-error-spot", "Endast alfabetiska bokstäver.");
		}

		if ( !isEmail(email) ) {
			allCorrect = false;
			printErrorMessage("email-error-spot", "Ange en giltig emailadress.");
		}


		if ( allCorrect ) {
			// Update request
			updateAccountInformation(firstname, lastname, email);
		}
		
	});

	// Undo the save confirm message if an setting is updated
	$("#input-notrec").on("change", function(){
		$("#other-settings-confirmation").hide();
	});
	$("#input-notcom").on("change", function(){
		$("#other-settings-confirmation").hide();
	});
	$("#input-savemethod").on("change", function(){
		$("#other-settings-confirmation").hide();
	});
	$("#input-firstname").on("change", function(){
		$("#account-settings-confirmation").hide();
	});
	$("#input-lastname").on("change", function(){
		$("#account-settings-confirmation").hide();
	});
	$("#input-email").on("change", function(){
		$("#account-settings-confirmation").hide();
	});

	// Open ticket
	$(".show-ticket").on("click", function(event){
		showTicket(event);
	});

});

let ticketWindow;
// Show a ticket
function showTicket(event) {
	if ( ticketWindow != null ) {
		ticketWindow.close();
	}
	ticketWindow = window.open("../biljett/?id="+event.target.dataset.id, "TuffeTuffeTåg - Biljett", "width=500, height=800")
}

// Show a error message
function printErrorMessage(id, message) {
	$("#" + id).text(message);
	$("#" + id).addClass("error-border");
}

// Wipe all the error spots
function wipeAllErrorSpots() {

	wipeErrorSpot("firstname-error-spot");
	wipeErrorSpot("lastname-error-spot");
	wipeErrorSpot("email-error-spot");
	wipeErrorSpot("save-button-error-spot");

}

// Wipe a error spots
function wipeErrorSpot(id) {

	$("#" + id).text("");
	$("#" + id).removeClass("error-border");

}



// Sends a AJAX request with the update request to the account information
function updateAccountInformation(firstname, lastname, email) {
	$.ajax({
		type: "PUT",
		url: "../assets/api/update-account.php",
		data: "firstname=" + firstname + "&lastname=" + lastname + "&email=" + email,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		success: () => {
			// Show the confirmation text
			$("#account-settings-confirmation").fadeIn(1000);
			$("#information-firstname").text(firstname);
			$("#information-lastname").text(lastname);
			$("#information-email").text(email);
		},
		error: (message) => {
			switch (message.status) {
				case 400:
					wipeAllErrorSpots();
					printErrorMessage("save-button-error-spot", "Inkorrekt input.");
					break;
				case 409:
					wipeAllErrorSpots();
					printErrorMessage("email-error-spot", "Ett annat konto har reda den email adressen");
					break;
			}
		}
	});
}

// Sends a AJAX request with the update request to the account settings
function updateSettingInformation(notificationRecommended, notificationUpcoming, paymentSave) {
	$.ajax({
		type: "PUT",
		url: "../assets/api/update-preferences.php",
		data: "notification-recommended=" + notificationRecommended + "&notification-upcoming=" + notificationUpcoming + "&payment-save=" + paymentSave,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		success: (message) => {
			// Show the confirmation text
			$("#other-settings-confirmation").fadeIn(1000);
			console.log(message);
		},
		error: (message) => {
			switch (message.status) {
				case 400:
					wipeAllErrorSpots();
					printErrorMessage("other-save-error-spot", "Inkorrekt input.");
					break;
				case 500:
					wipeAllErrorSpots();
					printErrorMessage("other-save-error-spot", "Ett fel inträffade vid sparningen, försök igen senare.");
					break;
			}
		}
	});
}