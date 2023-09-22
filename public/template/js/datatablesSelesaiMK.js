$(document).ready(function () {
    // var dataTable = $('#dataTable').DataTable();
    var dataTable = $('#dataTableSelesaiMK').DataTable({
        columns: [
            { searchable: false }, // No
            { searchable: true }, // Nama Karyawan
            { searchable: true }, // Jenis Reimbursement
            { searchable: true }, // Tanggal Reimbursement
            { searchable: true }, // Total
            { searchable: true }, // Status Pengajuan
            { searchable: false } // Aksi
        ]
    });

    dataTable.on('search.dt', function () {
        var searchValue = dataTable.search();
        var searchInput = $('input[type="search"]');

        searchInput.val(searchValue);

        // Get the current URL and remove any existing "search" parameter
        var currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('search');

        // Add the updated search value to the URL
        currentUrl.searchParams.append('search', searchValue);

        // Construct the export URL with the modified search parameter
        var exportUrl = currentUrl.origin + currentUrl.pathname.replace('/selesai-reimbursement', '') + '/selesai-reimbursement-export-excel' + currentUrl.search;

        $('#exportButton').attr('href', exportUrl);
    });
});