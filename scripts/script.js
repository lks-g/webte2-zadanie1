$(document).ready(function () {
    $('#olympic-table').DataTable({
        "paging": true,
        "pageLength": 10
    });
});

$(document).ready(function () {
    $('#olympic-table tbody tr').on('click', function () {
        // získať id športovca z atribútu data-id
        var id = $(this).attr('data-id');

        // získať údaje o umiestnení konkrétneho športovca
        $.ajax({
            url: 'get_placements.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                // vytvoriť novú tabuľku s umiestneniami
                var placementsTable = $('#placements-table').DataTable({
                    data: response,
                    columns: [
                        { title: 'Rok', data: 'year' },
                        { title: 'Mesto', data: 'city' },
                        { title: 'Krajina', data: 'country' },
                        { title: 'Typ', data: 'type' },
                        { title: 'Disciplína', data: 'discipline' },
                        { title: 'Umiestnenie', data: 'placing' }
                    ]
                });

                // skryť tabuľku s osobami a zobraziť tabuľku s umiestneniami
                $('#olympic-table-container').hide();
                $('#placements-table-container').show();

                // pridať tlačidlo späť do pravého dolného rohu
                var backButton = $('<button type="button" class="btn btn-secondary">Späť</button>');
                backButton.on('click', function () {
                    // zrušiť novú tabuľku a zobraziť tabuľku s osobami
                    placementsTable.destroy();
                    $('#placements-table-container').hide();
                    $('#olympic-table-container').show();
                });
                $('#placements-table-container').append(backButton);
            },
            error: function () {
                alert('Chyba pri získavaní údajov o umiestnení.');
            }
        });
    });
});
