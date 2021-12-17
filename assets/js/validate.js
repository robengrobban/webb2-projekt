// Validate if it is a email
function isEmail(email) {
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

// Validate if it is a name
function isName(name) {
	var regex = /^[A-Öa-ö]+$/;
	return regex.test(name);
}

// Validate if it is a phone number or not
function isPhoneNumber(phone) {
	var regex = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;
	return regex.test(phone);
}

// Validate if it is only numbers or not
function isOnlyNumbers(numbers) {
	var regex = /^[0-9]+$/;
	return regex.test(numbers);
}

// Validate if it is a date or not
function isDate(date) {
	var regex = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
	return regex.test(date);
}

// Validate if it is a fullname or not
function isFullname(name) {
	var regex = /^[A-Öa-ö]+( [A-Öa-ö]+)*$/;
	return regex.test(name);
}

// Validate if it is card expire date
function isCardExpireDate(date) {
	var regex = /^[0-9]{2}\/[0-9]{2}$/;
	return regex.test(date);
}

// Validate if it is a time
function isTime(time) {
	var regex = /^([0-9]{1}|[0-9]{2}):[0-9]{2}$/;
	return regex.test(time);
}