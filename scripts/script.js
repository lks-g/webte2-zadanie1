$(document).ready(function () {
    $('#olympic-table').DataTable({
        "paging": true,
        "pageLength": 10
    });
});

$('.edit-btn').on('click', function () {
    var name = $(this).closest('tr').data('name');
    var surname = $(this).closest('tr').data('surname');
    var birthDay = $(this).closest('tr').data('birth-day');
    var birthPlace = $(this).closest('tr').data('birth-place');
    var birthCountry = $(this).closest('tr').data('birth-country');
    var deathDay = $(this).closest('tr').data('death-day');
    var deathPlace = $(this).closest('tr').data('death-place');
    var deathCountry = $(this).closest('tr').data('death-country');

    $('#name').val(name);
    $('#surname').val(surname);
    $('#birthDay').val(birthDay);
    $('#birthPlace').val(birthPlace);
    $('#birthCountry').val(birthCountry);
    $('#deathDay').val(deathDay);
    $('#deathPlace').val(deathPlace);
    $('#deathCountry').val(deathCountry);
});