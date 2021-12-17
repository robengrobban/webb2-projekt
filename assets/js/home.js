
let latestFromResults;
let latestDestResults;

let fromOkay = false;
let destOkay = false;


$(document).ready(function(){

	// Show suggestion on input
	$("#input-from").on("input", async function(event) {

		try {
			let name = $("#input-from").val().trim();

			let result = await getLocationByName(name, "");
			latestFromResults = result;

			fromOkay = true;
			regulateInputField();

			displayLocationResult(result, "input-from-suggestions", (location) => {
				copySelectedSuggestion(location, "input-from");
			});
		}
		catch (error) {
			latestFromResults = "";

			fromOkay = false;
			regulateInputField();

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

			let result = await getLocationByName(name, "");
			latestDestResults = result;

			destOkay = true;
			regulateInputField();

			displayLocationResult(result, "input-dest-suggestions", (location) => {
				copySelectedSuggestion(location, "input-dest");
			});
		}
		catch (error) {
			latestDestResults = "";

			destOkay = false;
			regulateInputField();

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
	regulateInputField();
}

// Function for regulating the input fields for date and time
async function regulateInputField() {

	if ( fromOkay && destOkay ){
		try {

			let nameFrom = $("#input-from").val().trim();
			let resultFrom = await getLocationByName(nameFrom, "");

			let nameDest = $("#input-dest").val().trim();
			let resultDest = await getLocationByName(nameDest, "");

			if ( resultFrom.length === 1 && resultDest.length === 1 ) {

				let locationFrom = resultFrom[0].id;
				let locationTo = resultDest[0].id;

				let trips = await getTripsBetween(locationFrom, locationTo, "");

				displayDateAndTime(trips);

			}

		}
		catch ( error ) {
			$("#input-departure").empty();
		}
	}
	else {
		$("#input-departure").empty();
	}

}

// Display date and time information
function displayDateAndTime(json) {

	$("#input-departure").empty();

	for ( let i = 0; i < json.length; i++ ) {
		let entry = json[i];
		$("#input-departure").append("<option value='"+entry.id+"'>"+entry.departure+" från spår "+entry.track+"</option>");
	}

}