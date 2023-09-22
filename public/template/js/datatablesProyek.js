$(document).ready(function () {
    $('#dataTableProyek').DataTable({
        columnDefs: [
            { targets: [4], searchable: false } // Disables searching on the "Aksi" column (index 7)
        ],
        columns: [
            { searchable: false }, // No
            { searchable: true }, // Nomor Role
            { searchable: true }, // Nama Role
            { searchable: false }, // Status
            { searchable: false } // Aksi
        ]
    });
});