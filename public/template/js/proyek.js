function showhideproyek(select) {
    var proyek = document.getElementById('proyek')
    if (select.value == '2') {
        proyek.style.display = ''
    } else {
        proyek.style.display = 'none'
        proyek.value = ''
    }
}


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