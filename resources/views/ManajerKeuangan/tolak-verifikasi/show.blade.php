<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>

    <title>Detail Verifikasi Tolak Reimbursement</title>

    @include('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('template.left-sidebar-ManajerKeuangan')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar-ManajerKeuangan')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-2 text-gray-800">Table Data Master Role</h1>
                    <p class="mb-4">Data master role berisikan data role</p> --}}

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="font-weight-bold text-gray-900">
                                <a href="/manajer-keuangan/tolak-verifikasi" class="arrow-link">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a>
                                Detail Reimbursement
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Reimbursement
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f; " value="{{ $reimbursement->nama_jenis_reimbursement }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nomor Identitas
                                    Karyawan
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f;" value="{{ $reimbursement->nomor_identitas_karyawan }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama Karyawan
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f; " value="{{ $reimbursement->nama_karyawan }}" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama
                                    Supplier</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_supplier" name="id_supplier" style="color: #1f1f1f; "
                                        value="{{ $lamp1->nama_supplier ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama
                                    Proyek</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_proyek" name="id_proyek" style="color: #1f1f1f; "
                                        value="{{ $lamp2->nama_proyek ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class=" form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
                                    Bayar
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f; "
                                        value="{{ \Carbon\Carbon::parse($reimbursement->tanggal_bayar)->format('d-m-Y') }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
                                    Reimbursement
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f;"
                                        value="{{ \Carbon\Carbon::parse($reimbursement->tanggal_reimbursement)->format('d-m-Y') }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Total
                                    Reimbursement
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f; "
                                        value="{{ number_format($reimbursement->total, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label"
                                    style="color: black; width: 25%;">Deskripsi</label>
                                <div class="col-sm-9 text-justify">
                                    <textarea class="form-control-plaintext mb-1" aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f; " readonly>{{ $reimbursement->keterangan }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                    Pengajuan
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="id_reimbursement" name="id_reimbursement"
                                        style="color: #1f1f1f; " value="{{ $reimbursement->nama_status_pengajuan }}"
                                        readonly>
                                </div>
                            </div>
                            @if (
                                !empty($reimbursement->total_setuju_mk) &&
                                    ($reimbursement->id_status_pengajuan_mk == 8 ||
                                        $reimbursement->id_status_pengajuan_mk == 17 ||
                                        $reimbursement->id_status_pengajuan_mk == 6 ||
                                        $reimbursement->id_status_pengajuan_mk == 5))
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Total
                                        Yang Disetujui</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="id_reimbursement" name="id_reimbursement"
                                            style="color: #1f1f1f;"
                                            value="{{ number_format($reimbursement->total_setuju_mk, 0, ',', '.') }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($reimbursement->total_pembayaran_diterima))
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Total
                                        Pembayaran Diterima</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="id_reimbursement" name="id_reimbursement"
                                            style="color: #1f1f1f;"
                                            value="{{ number_format($reimbursement->total_pembayaran_diterima, 0, ',', '.') }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif
                        </div>



                        <div class="card-body">
                            <div class="card-header py-3 d-flex align-items-center">
                                <i class="fas fa-history text-black"></i>
                                <h6 class="m-0 font-weight-bold text-gray-900 ml-2">Histori Verifikasi Status
                                    Reimbursement Kepala Divisi</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">User
                                        Verifikasi</label>
                                    <div class="col-sm-9">
                                        @php
                                            $userVerifikasi = DB::table('users')
                                                ->where('id_user', $reimbursement->id_user_verifikasi)
                                                ->first();
                                            $namaKaryawan = !empty($userVerifikasi) ? $userVerifikasi->nama_karyawan : 'Belum ada';
                                        @endphp
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="id_user_verifikasi" name="id_user_verifikasi"
                                            style="color: #1f1f1f;" value="{{ $namaKaryawan }}" readonly>
                                    </div>
                                </div>


                                <div class="form-group mb-1  row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                        Pengajuan
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="nama_status_pengajuan" name="nama_status_pengajuan"
                                            style="color: #1f1f1f; "
                                            value="{{ $reimbursement->nama_status_pengajuan ?: '-' }}" readonly>
                                    </div>
                                </div>

                                @if ($reimbursement->id_status_pengajuan == 34)
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">Alasan
                                            Revisi
                                        </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control-plaintext mb-1"aria-describedby="alasan_revisi_kd" name="alasan_revisi_kd"
                                                style="color: #1f1f1f; " readonly>{{ $reimbursement->alasan_revisi_kd ?: '-' }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if ($reimbursement->id_status_pengajuan == 11)
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">Alasan
                                            Tolak
                                        </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control-plaintext mb-1" aria-describedby="alasan_ditolak_kd " name="alasan_ditolak_kd"
                                                style="color: #1f1f1f;" readonly>{{ $reimbursement->alasan_ditolak_kd ?: '-' }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
                                        Verifikasi</label>
                                    <div class="col-sm-9">

                                        @php
                                            $tanggalVerifikasiKD = !empty($reimbursement->tanggal_verifikasi_kd)
                                                ? \Carbon\Carbon::parse($reimbursement->tanggal_verifikasi_kd)
                                                    ->locale('id')
                                                    ->isoFormat('DD MMMM YYYY HH:mm:ss')
                                                : '-';
                                        @endphp

                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="tanggal_verifikasi_kd" name="tanggal_verifikasi_kd"
                                            style="color: #1f1f1f; " value="{{ $tanggalVerifikasiKD }}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="card-body">
                            <div class="card-header py-3 d-flex align-items-center">
                                <i class="fas fa-history text-black"></i>
                                <h6 class="m-0 font-weight-bold text-gray-900 ml-2">Histori Verifikasi Status
                                    Reimbursement Manajer Keuangan</h6>
                            </div>



                            <div class="card-body">
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">User
                                        Verifikasi</label>
                                    <div class="col-sm-9">
                                        @php
                                            $userVerifikasi = DB::table('users')
                                                ->where('id_user', $reimbursement->id_user_verifikasi_mk)
                                                ->first();
                                            $namaKaryawanMK = !empty($userVerifikasi) ? $userVerifikasi->nama_karyawan : 'Belum ada';
                                        @endphp
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="id_user_verifikasi_mk" name="id_user_verifikasi_mk"
                                            style="color: #1f1f1f; " value="{{ $namaKaryawanMK }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group mb-1  row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                        Pengajuan
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="nama_status_pengajuan_mk"
                                            name="nama_status_pengajuan_mk" style="color: #1f1f1f;"
                                            value="{{ $reimbursement->nama_status_pengajuan_mk ?: '-' }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Alasan
                                        Revisi
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="alasan_revisi_mk" name="alasan_revisi_mk"
                                            style="color: #1f1f1f; "
                                            value="{{ $reimbursement->alasan_revisi_mk ?: '-' }}" readonly>
                                    </div>

                                </div>

                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Alasan
                                        Tolak

                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="alasan_ditolak_mk" name="alasan_ditolak_mk"
                                            style="color: #1f1f1f; "
                                            value="{{ $reimbursement->alasan_ditolak_mk ?: '-' }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
                                        Verifikasi</label>
                                    <div class="col-sm-9">
                                        @php
                                            $tanggalVerifikasiMK = !empty($reimbursement->tanggal_verifikasi_mk) ? date('d-m-Y H:i:s', strtotime($reimbursement->tanggal_verifikasi_mk)) : '-';
                                        @endphp
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="tanggal_verifikasi_mk" name="tanggal_verifikasi_mk"
                                            style="color: #1f1f1f;" value="{{ $tanggalVerifikasiMK }}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="card-body">
                            <div class="card-header py-3 d-flex align-items-center">
                                <i class="fas fa-history text-black"></i>
                                <h6 class="m-0 font-weight-bold text-gray-900 ml-2">Histori Verifikasi Status
                                    Reimbursement Staff Keuangan</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">User
                                        Verifikasi</label>
                                    <div class="col-sm-9">
                                        @php
                                            $userVerifikasi = DB::table('users')
                                                ->where('id_user', $reimbursement->id_user_verifikasi_sk)
                                                ->first();
                                            $namaKaryawanSK = !empty($userVerifikasi) ? $userVerifikasi->nama_karyawan : 'Belum ada';
                                        @endphp
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="id_user_verifikasi_sk" name="id_user_verifikasi_sk"
                                            style="color: #1f1f1f; width: 300px;" value="{{ $namaKaryawanSK }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="form-group mb-1  row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                        Pengajuan
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="nama_status_pengajuan_sk"
                                            name="nama_status_pengajuan_sk" style="color: #1f1f1f;"
                                            value="{{ $reimbursement->nama_status_pengajuan_sk ?: '-' }}" readonly>
                                    </div>
                                </div>
                                @if ($reimbursement->id_status_pengajuan_sk == 45)
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Total
                                            Dibayar</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="total_dibayar_sk" name="total_dibayar_sk"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ $reimbursement->total_dibayar_sk ? 'Rp. ' . number_format($reimbursement->total_dibayar_sk, 2, '.', ',') : '-' }}"
                                                readonly>
                                        </div>
                                    </div>


                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">File</label>
                                        <div class="col-sm-9">

                                            @php
                                                $FileName = 'BuktiPembayaran';
                                                $extension = pathinfo($reimbursement->file_dibayar_sk, PATHINFO_EXTENSION);
                                                $time = time();
                                                $fileName = Auth::user()->nama_karyawan . '_' . date('dmY') . '_' . $time . '_' . $FileName . '.' . $extension;
                                                $filePath = public_path('BuktiPembayaran/' . $reimbursement->file_dibayar_sk);
                                                $fileUrl = file_exists($filePath) && in_array($extension, ['png', 'jpeg', 'jpg']) ? asset('BuktiPembayaran/' . $reimbursement->file_dibayar_sk) : null;
                                            @endphp

                                            @if ($fileUrl)
                                                <img src="{{ $fileUrl }}" alt="File Lampiran" width="200"
                                                    class="mb-2">
                                                <a href="{{ asset('BuktiPembayaran/' . $reimbursement->file_dibayar_sk) }}"
                                                    target="_blank" class="mb-2">Lihat Detail</a>
                                                <div>
                                                    <a href="{{ $fileUrl }}" download="{{ $fileName }}">
                                                        <button class="btn btn-primary btn-icon-split btn-sm">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-download"></i>
                                                            </span>
                                                            <span class="text">Unduh Gambar</span>
                                                        </button>
                                                    </a>
                                                </div>
                                            @elseif ($extension !== '')
                                                <p>File bukti pembayaran belum disertakan.</p>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">Tanggal
                                            Dibayar</label>
                                        <div class="col-sm-9">
                                            @php
                                                $tanggalVerifikasiSK = !empty($reimbursement->tanggal_verifikasi_sk)
                                                    ? \Carbon\Carbon::parse($reimbursement->tanggal_verifikasi_sk)
                                                        ->locale('id')
                                                        ->isoFormat('DD MMMM YYYY HH:mm:ss')
                                                    : '-';
                                            @endphp
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="tanggal_verifikasi_sk" name="tanggal_verifikasi_sk"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ $tanggalVerifikasiSK }}" readonly>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>


                    </div>



                    <div class="card shadow mb-10">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">Detail Lampiran Reimbursement</h6>
                        </div>


                        <div class="card-body">

                            @foreach ($lampirans as $index => $lampiran)
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-gray-900">Detail Lampiran Reimbursement
                                        {{ $index + 1 }}
                                    </h6>
                                </div>

                                <div class="card-body">
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nomor
                                            Lampiran</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="nomor_kwitansi" name="nomor_kwitansi"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ $lampiran->nomor_kwitansi }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">Tanggal
                                            Lampiran</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="tanggal_kwitansi" name="tanggal_kwitansi"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ \Carbon\Carbon::parse($lampiran->tanggal_kwitansi)->format('d-m-Y') }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Judul
                                            Lampiran</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="judul_kwitansi" name="judul_kwitansi"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ $lampiran->judul_kwitansi }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama
                                            Lampiran</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="nama_kwitansi" name="nama_kwitansi"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ $lampiran->nama_kwitansi }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">File</label>
                                        <div>
                                            <div class="col-sm-9">
                                                {{-- @php
                                            $extension = pathinfo($lampiran->file, PATHINFO_EXTENSION);
                                        @endphp --}}
                                                @php
                                                    $FileName = 'Lampiran';
                                                    $extension = pathinfo($lampiran->file, PATHINFO_EXTENSION);
                                                    $fileName = Auth::user()->nama_karyawan . '_' . date('dmY') . '_' . $FileName . '.' . $extension;
                                                @endphp

                                                @if (in_array($extension, ['png', 'jpeg', 'jpg']))
                                                    <img src="{{ $lampiran->fileUrl }}" alt="File Lampiran"
                                                        width="200" class="mb-2">
                                                    <a href="{{ asset('LampiranBaru/' . $lampiran->file) }}"
                                                        target="_blank" class="mb-2">Lihat Detail</a>
                                                    <div>
                                                        <a href="{{ $lampiran->fileUrl }}"
                                                            download="{{ $fileName }}">
                                                            <button class="btn btn-primary btn-icon-split btn-sm">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-download"></i>
                                                                </span>
                                                                <span class="text">Unduh Gambar</span>
                                                            </button>
                                                        </a>
                                                    </div>
                                                @elseif ($extension === 'pdf')
                                                    <iframe src="{{ $lampiran->fileUrl }}" width="100%"
                                                        height="300px"></iframe>
                                                    <a href="{{ asset('LampiranPDFBaru/' . $lampiran->file) }}"
                                                        target="_blank" class="mb-2">Lihat Detail PDF</a>
                                                    <div>
                                                        <a href="{{ $lampiran->fileUrl }}"
                                                            download="{{ $fileName }}">
                                                            <button class="btn btn-primary btn-icon-split btn-sm">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-download"></i>
                                                                </span>
                                                                <span class="text">Unduh PDF</span>
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label"
                                            style="color: black; width: 25%;">Keterangan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="keterangan" name="keterangan"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ $lampiran->keterangan }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Total
                                            Kwitansi</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext mb-1"
                                                aria-describedby="total_kwitansi" name="total_kwitansi"
                                                style="color: #1f1f1f; width: 300px;"
                                                value="{{ number_format($lampiran->total_kwitansi, 0, ',', '.') }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
