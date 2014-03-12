
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

	// Save the current amount of columns into a hidden field
	columnCount++;
	$('#num_columns').val(columnCount);

	event.preventDefault();
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
 * Initializes the javascript
 */
elgg.scheduling.init = function() {
	$('#scheduling-column-add').bind('click', elgg.scheduling.addColumn);

	$('#new_date').datepicker({
		dateFormat: 'yy-mm-dd', // ISO-8601
		//dateFormat: '@', // Timestamp in microseconds
		onSelect: elgg.scheduling.addRow,
	});
};

elgg.register_hook_handler('init', 'system', elgg.scheduling.init);
