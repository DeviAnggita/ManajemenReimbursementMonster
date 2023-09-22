<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Data Verifikasi Reimbursement Penunjang Kantor </title>

    @include('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('template.left-sidebar-StaffKeuangan')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar-StaffKeuangan')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h6 mb-0 text-gray-1000"></h2>
                        <a href="/manajer-keuangan/penunjang-kantor-export-excel"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div> --}}

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div class="col">
                            <div class="row mb-3">
                                <div class="col">
                                    <h2 class="h5 mb-0 text-gray-800">Reimbursement Penunjang Kantor-
                                        {{ $tahun_terpilih }}
                                    </h2>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="d-flex align-items-center mb-4 ml-3">
                                    <label for="bulan">Bulan:</label>
                                    <form method="GET" action="{{ route('penunjang-kantor-verifikasi-sk.index') }}"
                                        class="ml-3">
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
                                    <form method="GET" action="{{ route('penunjang-kantor-verifikasi-sk.index') }}"
                                        class="ml-3">
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
                                <a href="/staff-keuangan/penunjang-kantor-export-excel?bulan={{ $bulan_terpilih }}&tahun={{ $tahun_terpilih }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="exportButton">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan by Excel
                                </a>
                            </div>
                        </div>
                    </div>









                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">Data Tabel Verifikasi
                                Reimbursement Penunjang Kantor
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- KONTEN -->
                                <table class="table table-bordered" id="dataTablePenunjangKantorMK" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Karyawan</th>
                                            <th>Nama Proyek</th>
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
                                            <th>Nama Proyek</th>
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
                                                {{-- <td>{{ $reimbursement->nomor_identitas_karyawan }}</td> --}}
                                                <td>{{ $reimbursement->nama_karyawan }}</td>
                                                {{-- <td>{{ $reimbursement->tanggal_bayar }}</td> --}}
                                                {{-- <td>{{ $reimbursement->nama_jenis_reimbursement }}</td> --}}
                                                <td>{{ $lampirans->where('id_reimbursement', $reimbursement->id_reimbursement)->first()->nama_supplier }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($reimbursement->tanggal_reimbursement)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                                </td>
                                                <td>{{ number_format($reimbursement->total, 0, ',', '.') }}</td>
                                                {{-- <td>{{ $reimbursement->keterangan }}</td> --}}
                                                <td>
                                                    @php
                                                        if ($reimbursement->id_status_pengajuan_sk == 45 && $reimbursement->id_status_pengajuan_ky == 42) {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan_sk;
                                                        } elseif ($reimbursement->id_status_pengajuan_sk == 46) {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan_sk;
                                                        } else {
                                                            $nama_status_pengajuan = $reimbursement->nama_status_pengajuan_ky;
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
                                                                $btnClass = 'btn  btn-secondary btn-icon-split btn-sm';
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
                                                {{--
                                            <font color='red'>{{ $reimbursement->nama_status_pengajuan }}</font>
                                            --}}

                                                <td class="d-flex">
                                                    {{-- SHOW VERIFIKASI KARYAWAN --}}
                                                    <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#showReimbursementModal-{{ $reimbursement->id_reimbursement }}">
                                                        <i class="fas fa-history text-black"></i>
                                                    </button>
                                                    @include('StaffKeuangan.penunjang-kantor-verifikasi.showVerifikasi')

                                                    <!-- UPDATE DIVISI -->
                                                    @if (!in_array($reimbursement->id_status_pengajuan_ky, [17, 6, 5]))
                                                        <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        {{-- MODAL UPDATE DIVISI --}}
                                                        @include('StaffKeuangan.penunjang-kantor-verifikasi.update')
                                                    @endif


                                                    {{-- SHOW Reimbursement Medical --}}
                                                    <a href="{{ route('penunjang-kantor-verifikasi-sk.show', $reimbursement->id_reimbursement) }}"
                                                        class="btn btn-info btn-circle btn-sm"
                                                        title="Show Reimbursement">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <!-- UPDATE Reimbursement Medical  -->
                                                    {{--
                                                <a href="{{ route('medical.edit', $reimbursement->id_reimbursement) }}"
                                                    class="btn btn-warning btn-circle btn-sm"
                                                    title="Update Reimbursement">
                                                    <i class="fas fa-edit"></i>
                                                </a> --}}
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
