
let screens = [
	"step-trip",
	"step-departure",
	"step-riders",
	"step-seats",
	"step-payment"
];
let currentScreen = 0;
let validators = [
	stepTripValidator,
	stepDepartureValidator,
	stepRidersValidator,
	stepSeatsValidator,
	stepPaymentValidator
];

let adults = 0;
let kids = 0;
let selectedSeats = 0;

let latestFromResults;
let latestDestResults;

let locationFrom;
let locationDest;

let trips;
let trip;
let seats;
let occupations;
let occupationSet = new Set();

let selectedSeatsId = [];

let GETdeparture;

$(document).ready(function(){

	// Remove default behavior for the form
	$("#order-form").on("submit", async function(e){
		//e.preventDefault();

		// Validate payment
		let okay = stepPaymentValidator();

		// If not okay, prevent submission. Otherwise, the form will submit and a trip will be ordered.
		if (!okay) {
			e.preventDefault();
		}
	});

	// Bind next and back buttons
	$(".controller-backward").on("click", function(){
		moveScreen(-1);
	});
	$(".controller-forward").on("click", function(){
		moveScreen(1);
	});


	// Put URL GET information into the page if they exsist
	putGETVariable();

	// Update selectedSetas on load
	updateSelectedSeats();

	// Show suggestion on input
	$("#input-from").on("input", async function(event) {

		try {
			let name = $("#input-from").val().trim();

			let result = await getLocationByName(name, "../");
			latestFromResults = result;

			fromOkay = true;

			displayLocationResult(result, "input-from-suggestions", (location) => {
				copySelectedSuggestion(location, "input-from");
			});
		}
		catch (error) {
			latestFromResults = "";

			fromOkay = false;

			displayLocationResult("", "input-from-suggestions", (location) => {
				copySelectedSuggestion(location, "input-from");
			});
		}

	});
	// Remove suggestion on out of focus
	$("#input-from").on("focusout", function(event) {
		displayLocationResult("", "input-from-suggestions", (location) => {
			copySelectedSuggestion(location, "input-from");
		});
	});

	// Add suggestion on focus
	$("#input-from").on("focusin", function(event) {
		displayLocationResult(latestFromResults, "input-from-suggestions", (location) => {
			copySelectedSuggestion(location, "input-from");
		});
	});

	// Show suggestion on input
	$("#input-dest").on("input", async function(event) {

		try {
			let name = $("#input-dest").val().trim();

			let result = await getLocationByName(name, "../");
			latestDestResults = result;

			destOkay = true;

			displayLocationResult(result, "input-dest-suggestions", (location) => {
				copySelectedSuggestion(location, "input-dest");
			});
		}
		catch (error) {
			latestDestResults = "";

			destOkay = false;

			displayLocationResult("", "input-dest-suggestions", (location) => {
				copySelectedSuggestion(location, "input-dest");
			});
		}

	});
	// Remove suggestion on out of focus
	$("#input-dest").on("focusout", function(event) {
		displayLocationResult("", "input-dest-suggestions", (location) => {
			copySelectedSuggestion(location, "input-dest");
		});
	});

	// Add suggestion on focus
	$("#input-dest").on("focusin", function(event) {
		displayLocationResult(latestDestResults, "input-dest-suggestions", (location) => {
			copySelectedSuggestion(location, "input-dest");
		});
	});

});


// Function for displaying suggestion result when you search for a location
function displayLocationResult(json, id, handler) {

	$("#"+id).empty();
	$("#"+id).removeClass("suggestion-border-bottom");

	if ( json ) {
		for ( let i = 0; i < json.length; i++ ) {
			let entry = json[i];
			$("#"+id).append(function () {
				return $("<li>"+entry.name[0].toUpperCase()+entry.name.substring(1)+"</li>").on("mousedown", function () {
					let location = entry.name[0].toUpperCase()+entry.name.substr(1);
					handler(location);
				});
			});
		}
		if (json.length > 0) {
			$("#"+id).addClass("suggestion-border-bottom");
		}
	}
}

// Function for copying the a location name to an input field with an ID
function copySelectedSuggestion(location, id) {
	$("#"+id).val(location);
}


// Update the selected seats screen
function updateSelectedSeats() {
	$("#seat-select-header h2").text(adults + kids - selectedSeats + " kvar att välja.");
}

// Try to occupie a seat
function occupieSeat(e) {
	// Check so that there are setas to select
	let target = $(e.target);
	let canSelectMore = adults + kids - selectedSeats > 0;

	let data = $(e.target).data("seat-id");

	// A seat can be occupied if you can select more and if it already is not already selecetd
	if ( canSelectMore && !target.hasClass("seat-selected") ) {
		target.addClass("seat-selected");
		selectedSeats++;
		selectedSeatsId.push(data);
	}
	// A seat can be unselected if you have it selected
	else if ( target.hasClass("seat-selected") ) {
		target.removeClass("seat-selected");
		selectedSeats--;
		removeFromArray(selectedSeatsId, data);
	}

	updateSelectedSeats();
	
}

// Helper function that removes element from the array
function removeFromArray(array, element) {
	const index = array.indexOf(element);
	if ( index > -1 ){
		array.splice(index, 1);
	}
}

// Correct the selcetd seats. This will be dun after you select 
function correctSelectedSeats() {
	// If the number of people going on the train has changed and if it became
	// so that the number of seat selected is more than people, restart the process of selecting.
	if ( adults + kids - selectedSeats < 0 ) {
		selectedSeats = 0;
		$(".select-chair").removeClass("seat-selected");
		updateSelectedSeats();
	}
}

// Function to move the screen
async function moveScreen(diff) {
	wipeAllErrorSpots();
	let okay = true;
	if ( diff > 0 ) {
		okay = await validateCurrentScreen();
	}
	if ( okay ) {
		updateSelectedSeats();
		hideScreens();
		currentScreen += diff;
		controllBounds();
		showCurrentScreen();
		if ( screens[currentScreen] == "step-seats" ) {
			correctSelectedSeats();
		}
	}
}
// Controll so that the bounds are corecctly set
function controllBounds() {
	if ( currentScreen < 0 ) {
		currentScreen = 0;
	}
	else if ( currentScreen > screens.length ) {
		currentScreen = screens.length-1;
	}
}
// Hide all screens
function hideScreens() {
	for ( let i = 0; i < screens.length; i++ ) {
		$("#"+screens[i]).hide();
	}
}
// Show the current screen
function showCurrentScreen() {
	$("#"+screens[currentScreen]).show();
}
// Validate the current screen
async function validateCurrentScreen() {
	return validators[currentScreen]();
}

// Validate information with trip location step
async function stepTripValidator() {
	let okay = true;

	let from = $("#input-from").val().trim();
	let dest = $("#input-dest").val().trim();

	if ( !isName(from) ) {
		okay = false;
		printErrorMessage("from-error-spot", "Endast alfabetiska bokstäver.");
	}
	if ( !isName(dest) ) {
		okay = false;
		printErrorMessage("dest-error-spot", "Endast alfabetiska bokstäver.");
	}

	try {
		let fromResult = await getLocationByName(from, "../");
		let destResult = await getLocationByName(dest, "../");

		if ( fromResult.length === 0 ) {
			okay = false;
			printErrorMessage("from-error-spot", "Det finns ingen resa från denna plats.");
		}
		if ( destResult === 0 ) {
			okay = false;
			printErrorMessage("dest-error-stop", "Det finns ingen resa till denna plats.");
		}
		locationFrom = fromResult;
		locationDest = destResult;

		$("#input-from-id").val(locationFrom[0].id);
		$("#input-dest-id").val(locationDest[0].id);

	}
	catch ( error ) {
		okay = false;
	}

	if ( okay ) {
		// Load in trip information for the next screens
		loadTrips(locationFrom[0].id, locationDest[0].id);
	}

	return okay;

}

// Load the trips between two destinations
async function loadTrips(fromId, toId) {
	trips = await getTripsBetween(fromId, toId, "../");
	displayDepartures();
}

// Display departure
function displayDepartures() {
	$("#input-departure").empty();

	for ( let i = 0; i < trips.length; i++ ) {
		let entry = trips[i];
		$("#input-departure").append("<option value='"+entry.id+"'>"+entry.departure+" från spår "+entry.track+"</option>");
	}
	$("#input-departure").val(GETdeparture).change();
}

// Validate information on the destination validator
async function stepDepartureValidator() {
	let okay = true;

	if ( $("#input-departure").val() === null ) {
		okay = false;
		printErrorMessage("departure-error-spot", "Ange en avgång.");
	}
	else {
		let departure = $("#input-departure").val().trim();

		// Get trip information about that departure
		try {

			trip = await getSingleTripFromId(departure, "../");

			seats = await getSeatsByTrain(trip.train_id, "../");

		}
		catch (error) {
			okay = false;
			printErrorMessage("departure-error-spot", "Den avgången finns inte längre. Uppdatera sidan och börja om.");
		}

	}

	return okay;
}

// Validate information on the riders step
async function stepRidersValidator() {
	let okay = true;

	// Remove all selected seats, resetting if someone uses back button.
	selectedSeats = 0;
	selectedSeatsId = [];
	occupationSet.clear();
	updateSelectedSeats();

	try {
		occupations = await getOccupationByTrip(trip.id, "../");

		// Add all of the seat ids from the occupation to the set
		for ( let i = 0; i < occupations.length; i++ ) {
			occupationSet.add(occupations[i].seat_id);
		}

	}
	catch (error) {}

	adults = $("#input-adults").val().trim();
	kids = $("#input-kids").val().trim();
	if ( !isOnlyNumbers(adults) ) {
		okay = false;
		printErrorMessage("adults-error-spot", "Endast siffror.");
	}
	if ( !isOnlyNumbers(kids) ) {
		okay = false;
		printErrorMessage("kids-error-spot", "Endast siffror.");
	}

	if ( okay && adults == 0 ) {
		okay = false;
		printErrorMessage("adults-error-spot", "Det måste minst finnas 1 vuxen.");
	}

	if ( okay ) {
		adults = parseInt(adults);
		kids = parseInt(kids);
	}
	else {
		adults = 0;
		kids = 0;
	}

	// Check if there are enough room
	let seatsLeft = seats.length - (occupations ? occupations.length : 0);

	if ( adults + kids > seatsLeft ) {
		okay = false;
		printErrorMessage("kids-error-spot", "Det finns inte tillräckligt med platser.");
		printErrorMessage("adults-error-spot", "Det finns inte tillräckligt med platser.");
	}

	// Prepare the seat select screen
	prepareSeatScreen();

	return okay;
}

// Prepare the seat select screen with seats and their occupations
function prepareSeatScreen() {
	// Prepare the screen of choosing seats
	$("#seats-container").empty();
	let closedRow = false;
	let completedRow = false;
	let completedThusFar = 0;
	let toAppend = "";
	for ( let i = 0; i < seats.length; i++ ) {
		let seat = seats[i];

		if ( i % 18 === 0 ) {
			toAppend += "<div class='seat-row'><div class='select-item'></div></div>";
		}

		if ( i % 6 === 0 ) {
			toAppend += "<div class='seat-row'>";
			closedRow = false;
			completedRow = false;
		}

		console.log(i);
		if ( occupationSet.has(seat.seat_id) ) {
			toAppend += "<div class='select-item select-chair seat-occupied' data-seat-id='"+seat.seat_id+"'></div>";
			completedThusFar++;
		}
		else {
			toAppend += "<div class='select-item select-chair' data-seat-id='"+seat.seat_id+"'></div>";
			completedThusFar++;
		}

		if ( i % 6 === 2) {
			toAppend += "<div class='select-item'></div>";
			completedThusFar++;
		}

		if ( i % 6 === 5 ) {
			console.log("Closes last div");
			toAppend += "</div>";
			closedRow = true;
			completedRow = true;
			completedThusFar = 0;
		}
	}
	if ( !completedRow ) {
		for ( let i = 0; i < 7 - completedThusFar; i++) {
			toAppend += "<div class='select-item'></div>";
		}
	}
	if ( !closedRow ) {
		toAppend += "</div>";
	}
	$("#seats-container").append(toAppend);
	$("#seats-container").append("<div class='seat-row'><div class='select-item'></div></div>");

	// Bind seats with function to press it
	$(".select-chair:not(.seat-occupied)").on("click", function(e){ occupieSeat(e); });
}

// Validate information on the seats step
function stepSeatsValidator() {
	let okay = true;

	if ( adults + kids - selectedSeats > 0 ) {
		okay = false;
		printErrorMessage("seat-error-spot", "Välj platser till alla som ska vara med.");
	}
	if ( okay ) {

		let seats = "";
		let prefix = ":";
		for (let i = 0; i < selectedSeatsId.length; i++) {
			if ( i === 0 ) {
				seats += selectedSeatsId[i];
			}
			else {
				seats += prefix + selectedSeatsId[i];
			}
		}

		$("#input-seats").val(seats);

	}

	return okay;
}

// Validate information on the payment step
function stepPaymentValidator() {
	let okay = true;

	let card = $("#input-card").val().trim();
	let holder = $("#input-holder").val().trim();
	let expDate = $("#input-expire").val().trim();
	let cvv = $("#input-cvv").val().trim();

	if ( !isOnlyNumbers(card) ) {
		okay = false;
		printErrorMessage("card-error-spot", "Endast siffror.");
	}
	else if ( card.length != 16 ) {
		okay = false;
		printErrorMessage("card-error-spot", "Ange 16 styken siffror.");
	}

	if ( !isFullname(holder) ) {
		okay = false;
		printErrorMessage("holder-error-spot", "Endast alfabetiska bokstäver.");
	}

	if ( !isCardExpireDate(expDate) ) {
		okay = false;
		printErrorMessage("expire-error-spot", "Ange en giltig utgångstid.");
	}

	if ( !isOnlyNumbers(cvv) || cvv.length != 3 ) {
		okay = false;
		printErrorMessage("cvv-error-spot", "Ange ett giltgt CVV.");
	}

	return okay;
}

// Show a error message
function printErrorMessage(id, message) {
	$("#" + id).text(message);
	$("#" + id).addClass("error-border");
}

// Wipe all the error spots
function wipeAllErrorSpots() {

	wipeErrorSpot("from-error-spot");
	wipeErrorSpot("dest-error-spot");
	wipeErrorSpot("departure-error-spot");
	wipeErrorSpot("adults-error-spot");
	wipeErrorSpot("kids-error-spot");
	wipeErrorSpot("seat-error-spot");
	wipeErrorSpot("card-error-spot");
	wipeErrorSpot("holder-error-spot");
	wipeErrorSpot("expire-error-spot");
	wipeErrorSpot("cvv-error-spot");

}

// Wipe a error spots
function wipeErrorSpot(id) {

	$("#" + id).text("");
	$("#" + id).removeClass("error-border");

}

// Get the GET variables form the URL
function GETVariable(variable) {
    let GETInfo = window.location.search.substring(1).split("&");
    let list = new Array();
    for (let i = 0; i < GETInfo.length; i++) {
        let pair = GETInfo[i].split('=');
        list.push(pair);
    }
    return list;
}

// Put GET information inside of the page
function putGETVariable() {

	let variables = GETVariable(window.location.search);

	for ( let i = 0; i < variables.length; i++ ) {

		let key = decodeURIComponent(variables[i][0]);
		let value = decodeURIComponent(variables[i][1]);

		if ( key === "from" ) {
			$("#input-from").val(value);
		}
		else if ( key === "to" ) {
			$("#input-dest").val(value);
		}
		else if ( key === "departure" ) {
			value = value.replace("+", " ");
			GETdeparture = value;
			$("#input-departure").empty();
			$("#input-departure").append("<option value='"+value+"'>"+value+"</option>");
		}

	}

}