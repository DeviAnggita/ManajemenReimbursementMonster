$(document).ready(function() {
    // var dataTable = $('#dataTable').DataTable();
    var dataTable = $('#dataTablePenunjangKantorSA').DataTable({
        columns: [
            { searchable: false }, // No
            { searchable: true }, // Nama Karyawan
            { searchable: true }, // Nama Supplier
            { searchable: true }, // Tanggal Reimbursement
            { searchable: true }, // Total
            { searchable: true }, // Status Pengajuan
            { searchable: false } // Aksi
        ]
    });

    dataTable.on('search.dt', function() {
        var searchValue = dataTable.search();
        var searchInput = $('input[type="search"]');

        searchInput.val(searchValue);

        // Get the current URL and remove any existing "search" parameter
        var currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('search');

        // Add the updated search value to the URL
        currentUrl.searchParams.append('search', searchValue);

        // Construct the export URL with the modified search parameter
        var exportUrl = currentUrl.origin + currentUrl.pathname.replace('/penunjang-kantor', '') + '/penunjang-kantor-export-excel' + currentUrl.search;

        $('#exportButton').attr('href', exportUrl);
    });
});