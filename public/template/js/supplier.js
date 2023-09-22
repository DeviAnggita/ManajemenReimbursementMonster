function showhidesupplier(select) {
    var supplier = document.getElementById('supplier')
    if (select.value == '4') {
        supplier.style.display = ''
    } else {
        supplier.style.display = 'none'
        supplier.value = ''
    }
}



// function showhidesupplier(selectElement) {
//     var selectedValue = selectElement.options[selectElement.selectedIndex].value;
//     var formSupplier = document.getElementById("form-supplier");
//     var formProyek = document.getElementById("form-proyek");

//     if (selectedValue === "4") { // Ubah "1" dengan nilai id_jenis_reimbursement yang mengarahkan ke supplier
//         formSupplier.style.display = "block";
//         formProyek.style.display = "none";
//     } else if (selectedValue === "2") { // Ubah "2" dengan nilai id_jenis_reimbursement yang mengarahkan ke proyek
//         formSupplier.style.display = "none";
//         formProyek.style.display = "block";
//     } else {
//         formSupplier.style.display = "none";
//         formProyek.style.display = "none";
//     }
// }

// // Panggil fungsi saat halaman dimuat untuk menampilkan form yang sesuai dengan nilai awal jenis reimbursement
// showhidesupplier(document.querySelector('select[name="id_jenis_reimbursement"]'));


// function showhidesupplier(select) {
//     var supplier = document.getElementById('supplier');
//     var jenisReimbursement = document.getElementById('tb_jenis_reimbursement').value;

//     if (jenisReimbursement == 'nama_supplier' && select.value == '1') {
//         supplier.style.display = '';
//     } else {
//         supplier.style.display = 'none';
//         supplier.value = '';
//     }
// }