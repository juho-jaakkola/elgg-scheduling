define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	/**
	 * Remove a column
	 */
	removeColumn = function () {
		var target = $(this).index() + 1;

		// There must be at least one option
		if (target > 2){
			$("#elgg-table-scheduling").find("tr :nth-child(" + target + ")").remove();
		}
	};

	/**
	 * Add a new column to each of the existing rows
	 *
	 * @return void
	 */
	addColumn = function () {
		var $table = $(this).closest('table');

		$table.find('tr').each(function () {
			var $last = $(this).find('.scheduling-input-time:last');
			var $clone = $last.clone(true);

			$clone.find('select').val('');

			$last.after($clone);

			if ($clone.is('th')) {
				var deleteIcon = $last.find('span').clone();

				var slot_number = $clone.siblings('.scheduling-input-time').andSelf().length;

				$clone.text(elgg.echo('scheduling:slot:title', [slot_number]));

				$clone.append(deleteIcon);
			}
		});
	};

	/**
	 * Copy row
	 *
	 * @return void
	 */
	copyRow = function () {
		destroyDatepicker();
		var $row = $(this).closest('tr');
		var $clone = $row.clone(true);
		var index = $row.data('index');
		var max_index = index;
		$row.siblings().each(function () {
			if ($(this).data('index') > max_index) {
				max_index = $(this).data('index');
			}
		});
		$row.after($clone);

		$clone.data('index', max_index + 1).attr('data-index', max_index + 1);
		$clone.find("[name*='[" + index + "]']").each(function () {
			var $elem = $(this);
			$elem.attr('name', $elem.attr('name').replace('[' + index + ']', '[' + $clone.data('index') + ']'));
		});
		initDatepicker();
	};

	/**
	 *
	 */
	deleteRow = function(e) {
		var confirmText = $(this).data('confirm') || elgg.echo('question:areyousure');
		if (!confirm(confirmText)) {
			return false;
		}

		$(this).closest('tr').fadeOut().remove();
	};

	/**
	 * Initializes the javascript
	 */
	init = function () {
		$(document).delegate('.scheduling-column-add', 'click', addColumn);
		$(document).delegate('.scheduling-row-copy', 'click', copyRow);
		$(document).delegate('.scheduling-row-delete', 'click', deleteRow);
		$(document).delegate('th.scheduling-input-time', 'click', removeColumn);
	};

	initDatepicker = function () {
		$('.scheduling-datepicker').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	};

	destroyDatepicker = function () {
		$('.scheduling-datepicker').datepicker('destroy');
		$('.scheduling-datepicker').removeClass("hasDatepicker").removeAttr('id');
	};

	elgg.register_hook_handler('init', 'system', init);
	elgg.register_hook_handler('init', 'system', initDatepicker);
});