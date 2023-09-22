// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable();
});


// // Call the dataTables jQuery plugin
// $(document).ready(function () {
//   var dataTable = $('#dataTable').DataTable();

//   // Add event listener for the search event
//   dataTable.on('search.dt', function () {
//     var searchValue = dataTable.search(); // Get the current search value
//     var searchInput = $('input[type="search"]'); // Assuming the search input has the default DataTables structure

//     // Set the search value to the search input field
//     searchInput.val(searchValue);

//     // Trigger the form submission to export the Excel file
//     searchInput.closest('form').submit();
//   });
// });


// $(document).ready(function () {
//   var dataTable = $('#dataTable').DataTable();

//   dataTable.on('search.dt', function () {
//     var searchValue = dataTable.search();
//     var searchInput = $('input[type="search"]');

//     searchInput.val(searchValue);

//     // Add the search value to the export URL
//     var exportUrl = searchInput.closest('form').attr('action') + '?search=' + searchValue;

//     $('#exportButton').attr('href', exportUrl);
//   });
// });

// $(document).ready(function () {
//   // var dataTable = $('#dataTable').DataTable();
//   var dataTable = $('#dataTable').DataTable({
//     columns: [
//       { searchable: false }, // No
//       { searchable: true }, // Nama Karyawan
//       { searchable: true }, // Tanggal Reimbursement
//       { searchable: true }, // Total
//       { searchable: true }, // Status Pengajuan
//       { searchable: false } // Aksi
//     ]
//   });

//   dataTable.on('search.dt', function () {
//     var searchValue = dataTable.search();
//     var searchInput = $('input[type="search"]');

//     searchInput.val(searchValue);

//     // Get the current URL and remove any existing "search" parameter
//     var currentUrl = new URL(window.location.href);
//     currentUrl.searchParams.delete('search');

//     // Add the updated search value to the URL
//     currentUrl.searchParams.append('search', searchValue);

//     // Construct the export URL with the modified search parameter
//     var exportUrl = currentUrl.origin + currentUrl.pathname.replace('/medical', '') + '/medical-export-excel' + currentUrl.search;

//     $('#exportButton').attr('href', exportUrl);
//   });
// });