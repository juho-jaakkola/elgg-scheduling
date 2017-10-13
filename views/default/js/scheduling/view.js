define(function(require) {
	var $ = require('jquery');

	// Make width of the scheduling table container as wide as the main
	// content area. This will trigger the "overflow: auto;" declaration
	// making it possible to scroll the table sideways in case its wider
	// than the viewport.
	$('#elgg-scheduling-answer-container').css('width', $('.elgg-main').width());
});
