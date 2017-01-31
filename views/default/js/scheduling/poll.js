
$('.possible-answer').on('click', function () {
    $('#not-available').checked;
    if ($('.possible-answer:checkbox:checked').length > 0) {
        $('#not-available').prop('checked', false);
    } else {
        $('#not-available').prop('checked', true);
    }
});