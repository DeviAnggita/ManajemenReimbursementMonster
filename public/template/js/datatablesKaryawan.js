$(document).ready(function () {
    $('#dataTableKaryawan').DataTable({
        columnDefs: [
            { targets: [5], searchable: false } // Disables searching on the "Aksi" column (index 7)
        ],
        columns: [
            { searchable: false }, // No
            { searchable: true }, // Nama (make it searchable)
            { searchable: true }, // Divisi
            { searchable: true }, // Role
            { searchable: false }, // Status
            { searchable: false } // Aksi
        ]
    });
});