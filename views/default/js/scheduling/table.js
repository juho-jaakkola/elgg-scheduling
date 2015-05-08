
elgg.provide('elgg.scheduling');

/**
 * Add a new column to each of the existing rows
 *
 * @param {Object} event
 * @return void
 */
elgg.scheduling.addColumn = function(event) {
	var rows = $('#elgg-table-scheduling tr');

	// Count columns leaving out the first one with dates
	var columnCount = $('#elgg-table-scheduling tr th').length -1;

	rows.each(function(key, value) {
		if (key === 0) {
			$(this).append('<th>' + elgg.echo('scheduling:slot:title', [columnCount]) + '</th>');
			return true;
		}

		var input = document.createElement('input');
		input.type = 'text';
		input.name = 'slot' + (key - 1) + '-' + columnCount;
		var cell = $(document.createElement('td')).append(input);

		$(this).append(cell);
	});

	columnCount++;

	event.preventDefault();
	return false;
};

/**
 * Add a new row with as many columns as in the existing rows
 *
 * @param {string} dateText
 * @return void
 */
elgg.scheduling.addRow = function(dateText) {
	var dateParts = dateText.split("-");

	var timestamp = Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2]);

	var date = new Date(timestamp);
	friendlyTime = date.format(elgg.echo('scheduling:date_format'));

	var columns = $('#elgg-table-scheduling th');
	var newRow = document.createElement('tr');
	newRow.id = timestamp / 1000;

	var rows = $('#elgg-table-scheduling tr');
	var newRowKey = rows.length - 1;

	$(columns).each(function(key, value) {
		var cell = document.createElement('td');

		var newColumnKey = key - 1;

		if (key === 0) {
			var input = document.createElement('input');
			input.type = 'hidden';
			input.value = timestamp / 1000;
			input.name = 'day' + newRowKey;

			$(cell).append(input).append(friendlyTime);
			$(newRow).append(cell);

			return true;
		}

		var input = document.createElement('input');
		input.type = 'text';
		input.name = 'slot' + newRowKey + '-' + newColumnKey;

		$(cell).append(input);
		$(newRow).append(cell);
	});

	$('#elgg-table-scheduling > tbody').append(newRow);

	// // Save the current amount of rows into a hidden field
	$('#num_rows').val(rows.length);
};

/**
 * Processes the entered times into timestamps before sending the form
 */
elgg.schedulingSubmit = function(event) {
	var slots = [];
	var selects = [];

	var rows = $('#elgg-table-scheduling tr');

	// Remove the first row which contains the table headings
	rows = rows.slice(1);

	rows.each(function(key, value) {
		var dayTimestamp = $(this).attr('id');

		selects = $(this).find('input[type=text]');

		selects.each(function(key, value) {
			// Javascript treats timestamps in milliseconds
			var date = new Date(dayTimestamp * 1000);

			// Get the entered time
			// TODO Validate the value
			var time = $(this).val();

			if (!time) {
				// Nothing was entered to the field
				return true;
			}

			// Separate the format HH:MM into hours and minutes
			var time = $(this).val().split(':');
			var hours = time[0];
			var minutes = time[1];

			var date = date.setHours(hours, minutes) / 1000;

		 	slots.push(date);
		});
	});

	$('#scheduling-slots').val(slots);
	$('#num-rows').val(rows.length);
	$('#num-columns').val(selects.length);
};

/**
 * Validate that time has been entered in format HH:MM
 *
 * @param String time
 * @return boolean
 */
elgg.scheduling.isValidTime = function (time) {
	return time.match(/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])?$/);
};

/**
 * Initializes the javascript
 */
elgg.scheduling.init = function() {
	$('#scheduling-column-add').bind('click', elgg.scheduling.addColumn);

	$('.elgg-form-scheduling-days').bind('submit', elgg.schedulingSubmit);

	$('#new_date').datepicker({
		dateFormat: 'yy-mm-dd', // ISO-8601
		//dateFormat: '@', // Timestamp in microseconds
		onSelect: elgg.scheduling.addRow,
	});

	$('#elgg-table-scheduling').bind('change', '.scheduling-slot', function(element) {
		var input = $(element.target);

		if (!elgg.scheduling.isValidTime(input.val())) {
			input.addClass('scheduling-state-error');
			elgg.register_error(elgg.echo('scheduling:error:invalid_format'));
			input.focus();
		} else {
			input.removeClass('scheduling-state-error');
		}
	});
};

elgg.register_hook_handler('init', 'system', elgg.scheduling.init);
