{{-- <script>
                            function sortDataAndExportToExcel() {
                                // Ambil data dari API atau sumber lainnya
                                fetch('/karyawan/medical')
                                    .then(response => response.json())
                                    .then(data => {
                                        // Urutkan data berdasarkan id_reimbursement
                                        data.sort((a, b) => a.id_reimbursement - b.id_reimbursement);

                                        // Buat objek Workbook dari data yang telah diurutkan
                                        var wb = XLSX.utils.book_new();
                                        var ws = XLSX.utils.json_to_sheet(data);
                                        XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");

                                        // Simpan Workbook sebagai file Excel
                                        var wbout = XLSX.write(wb, {
                                            bookType: 'xlsx',
                                            type: 'binary'
                                        });

                                        function s2ab(s) {
                                            var buf = new ArrayBuffer(s.length);
                                            var view = new Uint8Array(buf);
                                            for (var i = 0; i < s.length; i++) {
                                                view[i] = s.charCodeAt(i) & 0xFF;
                                            }
                                            return buf;
                                        }

                                        saveAs(new Blob([s2ab(wbout)], {
                                            type: "application/octet-stream"
                                        }), "data.xlsx");
                                    })
                                    .catch(error => {
                                        console.error('Terjadi kesalahan:', error);
                                    });
                            }

                            document.getElementById("download-button-id").addEventListener("click", sortDataAndExportToExcel);
                        </script>  --}}


{{-- <button id="download-button-id"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan Excel by Sort
                        </button>

                        <script src="{{ asset('FileSaver/src/FileSaver.js') }}"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script>
function sortDataAndExportToExcel() {
    const table = document.getElementById('dataTable');

    let no = 1;
    const data = [];
    table.querySelectorAll('tbody tr').forEach(row => {
        const nama_karyawan = row.querySelector('td:nth-child(2)').textContent;
        const tanggal_reimbursement = row.querySelector('td:nth-child(3)').textContent;
        const total = row.querySelector('td:nth-child(4)').textContent;
        const keterangan = row.querySelector('td:nth-child(5)').textContent;
        const status_pengajuan = row.querySelector('td:nth-child(6)').textContent;

        data.push({
            No: no++,
            Nama_Karyawan: nama_karyawan,
            Tanggal_Reimbursement: tanggal_reimbursement,
            Total: total,
            Keterangan: keterangan,
            Status Pengajuan: nama_status_pengajuan
        });
    });

    data.sort((a, b) => a.No - b.No);

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");

    const wbout = XLSX.write(wb, {
        bookType: 'xlsx',
        type: 'binary'
    });

    function s2ab(s) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }

    saveAs(new Blob([s2ab(wbout)], {
        type: "application/octet-stream"
    }), "data.xlsx");
}

document.getElementById("download-button-id").addEventListener("click", sortDataAndExportToExcel);
</script> --}}