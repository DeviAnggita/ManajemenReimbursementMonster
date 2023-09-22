// Mendapatkan elemen select status_pengajuan
var statusPengajuanSelect = document.getElementById('id_status_pengajuan');

// Mendapatkan elemen form alasan revisi
var formAlasanRevisi = document.getElementById('form-alasan-revisi');

// Mendapatkan elemen form alasan ditolak
var formAlasanDitolak = document.getElementById('form-alasan-ditolak');

// Menyembunyikan form alasan saat halaman dimuat
formAlasanRevisi.style.display = 'none';
formAlasanDitolak.style.display = 'none';

// Event listener untuk perubahan nilai select status_pengajuan
statusPengajuanSelect.addEventListener('change', function () {
    var selectedValue = this.value;

    // Menampilkan/menyembunyikan form alasan sesuai dengan nilai yang dipilih
    if (selectedValue === '34') {
        formAlasanRevisi.style.display = 'block';
        formAlasanDitolak.style.display = 'none';
    } else if (selectedValue === '11') {
        formAlasanRevisi.style.display = 'none';
        formAlasanDitolak.style.display = 'block';
    } else {
        formAlasanRevisi.style.display = 'none';
        formAlasanDitolak.style.display = 'none';
    }
});