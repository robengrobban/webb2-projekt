
// Gets a list of locations via a AJAX request
function getLocationByName(name, path) {
	return $.ajax({
		type: "GET",
		url: path + "assets/api/get-location.php",
		data: "name=" + name,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}

// Get trip information (four variable input)
function getSingleTripFromInfo(locationFrom, locationTo, departure, arrival, path) {
	return $.ajax({
		type: "GET",
		url: path + "assets/api/get-trip.php",
		data: "location-from=" + locationFrom + "&location-to=" + locationTo + "&departure=" + departure + "&arrival=" + arrival,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}
function getSingleTripFromId(id, path) {
	return $.ajax({
		type: "GET",
		url: path + "assets/api/get-trip.php",
		data: "id=" + id,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}

// Get trip information (two variable input)
function getTripsBetween(locationFrom, locationTo, path) {
	return $.ajax({
		type: "GET",
		url: path + "assets/api/get-trip.php",
		data: "location-from=" + locationFrom + "&location-to=" + locationTo,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}

// Get seats from a train
function getSeatsByTrain(trainId, path) {
	return $.ajax({
		type: "GET",
		url: path + "assets/api/get-seats.php",
		data: "train-id=" + trainId,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}

// Get occupation by trip
function getOccupationByTrip(tripId, path) {
	return $.ajax({
		type: "GET",
		url: path + "assets/api/get-occupation.php",
		data: "trip-id=" + tripId,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}

// Send information about a new subscriber
function addSubscriber(email, path) {
	return $.ajax({
		type: "POST",
		url: path + "assets/api/add-subscriber.php",
		data: "email=" + email,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}

// Send information about a new contact request with no respond
function doContactNoRespond(firstname, lastname, message, path) {
	return $.ajax({
		type: "POST",
		url: path + "assets/api/do-contact.php",
		data: "firstname=" + firstname + "&lastname=" + lastname + "&message=" + message,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}
// Send information about a new contact request with email respond
function doContactEmailRespond(firstname, lastname, message, email, path) {
	return $.ajax({
		type: "POST",
		url: path + "assets/api/do-contact.php",
		data: "firstname=" + firstname + "&lastname=" + lastname + "&message=" + message + "&email=" + email,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}
// Send information about a new contact request with phone respond
function doContactPhoneRespond(firstname, lastname, message, phone, path) {
	return $.ajax({
		type: "POST",
		url: path + "assets/api/do-contact.php",
		data: "firstname=" + firstname + "&lastname=" + lastname + "&message=" + message + "&phone=" + phone,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}
// Send information about a new contact request with letter respond
function doContactLetterRespond(firstname, lastname, message, adress, zip, path) {
	return $.ajax({
		type: "POST",
		url: path + "assets/api/do-contact.php",
		data: "firstname=" + firstname + "&lastname=" + lastname + "&message=" + message + "&adress=" + adress + "&zip=" + zip,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}