
let reviews = [];

// Variable for storing the review loop objekt
let reviewLoop;

// The current review index
let currentReview = 0;
// The maximum numbers of reviews, used to reset the current review index so that it loops.
let maxReviews = reviews.length;
// Length in seconds that a review should be shown before automatic switch
let reviewShowLength = 15;

let fadeInAndOut = 500;

// Function for controlling the loop for the reviews
function looperController() {
	
	hideReview();
	moveReview();
	controllIndex();
	setTimeout(function() {
		updateReview();
	},fadeInAndOut);
	showReview();

}

// Fade out the review information
function hideReview() {
	// Fade out review information
	$("#review-image").fadeOut(fadeInAndOut);
	$("#review-quote").fadeOut(fadeInAndOut);
	$("#review-author").fadeOut(fadeInAndOut);
}

// Update index information to get a new review
function moveReview() {
	// Move to the next review
	currentReview++;
}

// Controll so that the index is not out of bounds
function controllIndex() {
	// If the review is larger than the maximum number of reviews, loop around
	if ( currentReview >= maxReviews ) {
		currentReview = 0;
	}
	// If buttons are used to back to previous reviews, we need to be able to loop around the other way
	else if ( currentReview < 0 ) {
		currentReview = maxReviews-1;
	}
}

// Change the review information
function updateReview() {
	// Get the review
	let review = reviews[currentReview]

	// Update the infromation
	$("#review-image").attr("src", review.img);
	$("#review-quote").text(review.content);
	$("#review-author").text(review.name);

}

// Fade in the review information
function showReview() {
	// Fade in review information
	$("#review-image").fadeIn(fadeInAndOut);
	$("#review-quote").fadeIn(fadeInAndOut);
	$("#review-author").fadeIn(fadeInAndOut);
}

// Force a new review based on a number of steps
function forceNewReview(steps) {

	// Stop the automatic loop from switching
	stopLoop();

	// Move index number of steps
	currentReview += steps;

	// Performe checks so that the index is correct
	controllIndex();

	// Show the current review
	hideReview();
	setTimeout(function() {
		updateReview();
	},fadeInAndOut);
	showReview();
	
	// Start the loop again
	startLoop();

}


// Start the loop for the automatic new loops
function startLoop() {
	reviewLoop = setInterval(looperController, 1000 * reviewShowLength);
}
// End the automatic loop
function stopLoop() {
	clearInterval(reviewLoop)
}

$(document).ready(async function(){
	// Get the reviews
	let review = await getReviews();

	// Build the review list
	buildReviewList(review);

	// Update maximum number of reviews
	maxReviews = reviews.length;

	// Start the loop
	startLoop();
	// Initiate the first print
	updateReview();
	// Bind arrows
	$("#review-next-container").on("click", function() {
		forceNewReview(1);
	});
	$("#review-back-container").on("click", function() {
		forceNewReview(-1);
	});
});

function buildReviewList( json ) {
	reviews = [];
	for ( let i = 0; i < json.length; i++ ) {
		let name = json[i].firstname.charAt(0).toUpperCase() + json[i].firstname.slice(1).toLowerCase();
		let img = "assets/img/portrait-placeholder.jpg";
		if ( json[i].file ) {
			img = "assets/uploads/"+json[i].file;
		}
		let content = json[i].content;

		let review = {
			"name": name,
			"img": img,
			"content": content
		}

		reviews.push(review);
	}
	maxReviews = reviews.length;
}

// Get review information
function getReviews() {
	return $.ajax({
		type: "GET",
		url: "assets/api/get-reviews.php",
		dataType: "json",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8"
	});
}