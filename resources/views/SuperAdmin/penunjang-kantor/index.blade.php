<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Data Reimbursement Penunjang Kantor</title>

    @include('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('template.left-sidebar-SuperAdmin')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar-SuperAdmin')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-2 text-gray-800">Table Data Master Reimbursement Penunjang Kantor</h1>
                    <p class="mb-4">Data master reimbursement medical berisikan data reimbursement penunjang kantor</p> --}}

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <div class="col">
                            <div class="row mb-3">
                                <div class="col">
                                    <h2 class="h5 mb-0 text-gray-800">Reimbursement Penunjang Kantor -
                                        {{ $tahun_terpilih }}</h2>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="d-flex align-items-center mb-4 ml-3">
                                    <label for="bulan">Bulan:</label>
                                    <form method="GET" action="{{ route('penunjang-kantor.index') }}" class="ml-3">
                                        <select name="bulan" id="bulan" onchange="this.form.submit()"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            @php
                                                $bulan_options = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            @endphp
                                            <option value="all" {{ $bulan_terpilih == 'all' ? 'selected' : '' }}>
                                                All
                                            </option>
                                            @foreach ($bulan_options as $index => $bulan_option)
                                                <option value="{{ $index + 1 }}"
                                                    {{ $bulan_terpilih == $index + 1 ? 'selected' : '' }}>
                                                    {{ $bulan_option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="tahun" value="{{ $tahun_terpilih }}">
                                    </form>
                                </div>

                                <div class="d-flex align-items-center mb-4 ml-3">
                                    <label for="tahun">Tahun:</label>
                                    <form method="GET" action="{{ route('penunjang-kantor.index') }}" class="ml-3">
                                        <select name="tahun" id="tahun" onchange="this.form.submit()"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            @php
                                                $tahun_options = $tahun_options;
                                            @endphp
                                            <option value="all" {{ $tahun_terpilih == 'all' ? 'selected' : '' }}>
                                                All
                                            </option>
                                            @foreach ($tahun_options as $tahun_option)
                                                <option value="{{ $tahun_option }}"
                                                    {{ $tahun_terpilih == $tahun_option ? 'selected' : '' }}>
                                                    {{ $tahun_option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="bulan" value="{{ $bulan_terpilih }}">
                                    </form>
                                </div>
                            </div>


                        </div>


                        <div class="row justify-content-end">
                            <div class="col-xl-12 col-auto mb-3 text-right">
                                <a href="/superadmin/penunjang-kantor-export-excel?bulan={{ $bulan_terpilih }}&tahun={{ $tahun_terpilih }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="exportButton">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan by Excel
                                </a>
                            </div>

                            {{-- <div class="col-xl-7 col-md-6 mb-4 text-right">
                                <button id="download-button-id"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download Excel by Search
                                </button>
                            </div> --}}
                        </div>

                        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
                        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

                        <script>
                            function sortDataAndExportToExcel() {
                                const table = document.getElementById('dataTable');

                                let no = 1;
                                const data = [];
                                table.querySelectorAll('tbody tr').forEach(row => {
                                    const nama_karyawan = row.querySelector('td:nth-child(2) span').textContent;
                                    const tanggal_reimbursement = row.querySelector('td:nth-child(3)').textContent;
                                    const total = row.querySelector('td:nth-child(4)').textContent;
                                    const nama_status_pengajuan = row.querySelector('td:nth-child(5) a').getAttribute('title');

                                    data.push({
                                        'No': no++,
                                        'Nama Karyawan': nama_karyawan,
                                        'Tanggal Reimbursement': tanggal_reimbursement,
                                        'Total': total,
                                        'Status Pengajuan': nama_status_pengajuan,
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

                                const currentDate = new Date();
                                const year = currentDate.getFullYear();
                                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                                const day = String(currentDate.getDate()).padStart(2, '0');
                                const hours = String(currentDate.getHours()).padStart(2, '0');
                                const minutes = String(currentDate.getMinutes()).padStart(2, '0');
                                const seconds = String(currentDate.getSeconds()).padStart(2, '0');

                                const uniqueNumber = `${day}${month}${year}_${hours}${minutes}${seconds}`;


                                const filename = `Data Reimbursement Medical_${uniqueNumber}.xlsx`;

                                // const uniqueNumber = Date.now(); // Generate a unique number using the current timestamp

                                saveAs(new Blob([s2ab(wbout)], {
                                    type: "application/octet-stream"
                                }), filename);

                            }

                            document.getElementById("download-button-id").addEventListener("click", sortDataAndExportToExcel);
                        </script> --}}



                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">Laporan Reimbursement Penunjang Kantor</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- KONTEN -->
                                <table class="table table-bordered" id="dataTablePenunjangKantorSA" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Karyawan</th>
                                            <th>Nama Supplier</th>
                                            <th>Tanggal Reimbursement</th>
                                            <th>Total</th>
                                            <th>Status Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Karyawan</th>
                                            <th>Nama Supplier</th>
                                            <th>Tanggal Reimbursement</th>
                                            <th>Total</th>
                                            <th>Status Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot> --}}

                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($reimbursements as $reimbursement)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>
                                                    @if ($reimbursement->status_active == 1)
                                                        <span
                                                            class="text-primary">{{ $reimbursement->nama_karyawan }}</span>
                                                    @else
                                                        <span
                                                            class="text-danger">{{ $reimbursement->nama_karyawan }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $lampiran = $lampirans->where('id_reimbursement', $reimbursement->id_reimbursement)->first();
                                                    @endphp
                                                    @if ($lampiran->status_active == 1)
                                                        <span
                                                            class="text-primary">{{ $lampiran->nama_supplier }}</span>
                                                    @else
                                                        <span class="text-danger">{{ $lampiran->nama_supplier }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($reimbursement->tanggal_reimbursement)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                                </td>
                                                <td>{{ number_format($reimbursement->total, 0, ',', '.') }}</td>
                                                <td>
                                                    @php
                                                        if (!is_null($reimbursement->nama_status_pengajuan_ky)) {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan_ky;
                                                        } elseif (!is_null($reimbursement->nama_status_pengajuan_sk)) {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan_sk;
                                                        } elseif (!is_null($reimbursement->nama_status_pengajuan_mk)) {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan_mk;
                                                        } else {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan;
                                                        }
                                                        
                                                        $btnClass = '';
                                                        
                                                        switch ($nama_status_pengajuan) {
                                                            case 'Menunggu Persetujuan Kepala Divisi':
                                                            case 'Menunggu Persetujuan Manajer Keuangan':
                                                            case 'Menunggu Konfirmasi Karyawan':
                                                                $btnClass = 'btn btn-info btn-icon-split btn-sm';
                                                                $iconClass = 'fas fa-clock';
                                                                $text = $nama_status_pengajuan;
                                                                break;
                                                            case 'Disetujui Kepala Divisi':
                                                            case 'Disetujui Manajer Keuangan':
                                                                $btnClass = 'btn btn-success btn-icon-split btn-sm';
                                                                $iconClass = 'fas fa-check';
                                                                $text = $nama_status_pengajuan;
                                                                break;
                                                            case 'Ditolak Kepala Divisi':
                                                            case 'Ditolak Manajer Keuangan':
                                                                $btnClass = 'btn btn-danger btn-icon-split btn-sm';
                                                                $iconClass = 'fas fa-times';
                                                                $text = $nama_status_pengajuan;
                                                                break;
                                                            case 'Revisi Reimburse Manajer Keuangan':
                                                            case 'Revisi Reimburse Kepala Divisi':
                                                                $btnClass = 'btn btn-warning btn-icon-split btn-sm';
                                                                $iconClass = 'fas fa-exclamation-triangle';
                                                                $text = $nama_status_pengajuan;
                                                                break;
                                                            case 'Selesai Reimburse':
                                                                $btnClass = 'btn btn-secondary btn-icon-split btn-sm';
                                                                $iconClass = 'fas fa-check';
                                                                $text = $nama_status_pengajuan;
                                                                break;
                                                            default:
                                                                $btnClass = 'btn btn-primary btn-icon-split btn-sm';
                                                                $iconClass = 'fas fa-flag';
                                                                $text = $nama_status_pengajuan;
                                                                break;
                                                        }
                                                    @endphp

                                                    <a href="#" class="{{ $btnClass }}"
                                                        style="width: 140px; height: 40px;"
                                                        title="{{ $nama_status_pengajuan }}">
                                                        <span class="icon text-white-50">
                                                            <i class="{{ $iconClass }}"></i>
                                                        </span>
                                                        <span class="text small">{{ $text }}</span>
                                                    </a>

                                                </td>
                                                <td class="d-flex">

                                                    {{-- SHOW Reimbursement PENUNJANG KANTOR  --}}
                                                    <a href="{{ route('penunjang-kantor.show', $reimbursement->id_reimbursement) }}"
                                                        class="btn btn-info btn-circle btn-sm"
                                                        title="Show Reimbursement">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    {{-- MODAL SHOW PENUNJANG KANTOR --}}
                                                    <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#showReimbursementModal-{{ $reimbursement->id_reimbursement }}">
                                                        <i class="fas fa-history text-black"></i>
                                                    </button>
                                                    @include('SuperAdmin.penunjang-kantor.showVerifikasi')

                                                    <!-- UPDATE Reimbursement PENUNJANG KANTOR   -->
                                                    @if (in_array($reimbursement->id_user, $allowedUpdate))
                                                        <a href="{{ route('penunjang-kantor.edit', $reimbursement->id_reimbursement) }}"
                                                            class="btn btn-warning btn-circle btn-sm"
                                                            title="Update Reimbursement">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif


                                                    {{-- DELETE Reimbursement PENUNJANG KANTOR  --}}
                                                    <button type="button"
                                                        class="btn btn-danger btn-circle btn-sm flex-end"
                                                        data-toggle="modal" title="Delete Reimbursement"
                                                        data-target="#deleteModalPenunjangKantor{{ $reimbursement->id_reimbursement }}"><i
                                                            class="fas fa-trash"></i></button>
                                                    {{-- MODAL DELETE Supplier --}}
                                                    @include('SuperAdmin.penunjang-kantor.delete')
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('template.footer')

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    @include('template.script')
    @include('sweetalert::alert')


</body>

</html>
