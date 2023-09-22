$(document).ready(function () {
    $('#dataTableSupplier').DataTable({
        columnDefs: [
            { targets: [3], searchable: false } // Disables searching on the "Aksi" column (index 7)
        ],
        columns: [
            { searchable: false }, // No
            { searchable: true }, // Nama Role
            { searchable: false }, // Status
            { searchable: false } // Aksi
        ]
    });
});