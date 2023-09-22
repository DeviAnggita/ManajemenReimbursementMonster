$(document).ready(function () {
    $('#dataTableStatusPengajuan').DataTable({
        columnDefs: [
            { targets: [4], searchable: false } // Disables searching on the "Aksi" column (index 4)
        ],
        columns: [
            { searchable: false }, // No
            { searchable: true }, // Nama Status Pengajuan (set to searchable)
            { searchable: true }, // Nama Role (set to searchable)
            { searchable: false }, // Status (set to searchable)
            { searchable: false } // Aksi
        ]
    });
});