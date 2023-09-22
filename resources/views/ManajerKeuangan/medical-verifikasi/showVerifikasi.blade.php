<div class="modal fade" id="showReimbursementModal-{{ $reimbursement->id_reimbursement }}" tabindex="-1" role="dialog"
    aria-labelledby="showReimbursementLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('medical-verifikasi-mk.update', $reimbursement->id_reimbursement) }}" method="POST">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header  bg-danger">
                    <h5 class="modal-title" id="showReimbursementLabel" style="color: white;">History Verifikasi
                        Reimbursement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row justify-content-center">
                        <div class="col-sm-9">
                            <h4 style="text-align: center; font-weight: bold;">
                                {{ !is_null($reimbursement->nama_status_pengajuan_ky) ? $reimbursement->nama_status_pengajuan_ky : (!is_null($reimbursement->nama_status_pengajuan_mk) ? $reimbursement->nama_status_pengajuan_mk : $reimbursement->nama_status_pengajuan) }}
                            </h4>
                        </div>
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
                                        style="color: #1f1f1f; width: 300px;" value="{{ $namaKaryawan }}" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-1  row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                    Pengajuan
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="nama_status_pengajuan" name="nama_status_pengajuan"
                                        style="color: #1f1f1f; width: 300px;"
                                        value="{{ $reimbursement->nama_status_pengajuan ?: '-' }}" readonly>
                                </div>
                            </div>


                            @if ($reimbursement->id_status_pengajuan == 34)
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Alasan
                                        Revisi
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control-plaintext mb-1" aria-describedby="alasan_revisi_kd" name="alasan_revisi_kd"
                                            style="color: #1f1f1f; width: 300px;" readonly>{{ $reimbursement->alasan_revisi_kd ?: '-' }}</textarea>
                                    </div>
                                </div>
                            @endif

                            @if ($reimbursement->id_status_pengajuan == 11)
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Alasan
                                        Tolak
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control-plaintext mb-1" aria-describedby="alasan_ditolak_kd " name="alasan_ditolak_kd"
                                            style="color: #1f1f1f; width: 300px;" readonly>{{ $reimbursement->alasan_ditolak_kd ?: '-' }}</textarea>
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
                                        style="color: #1f1f1f; width: 300px;" value="{{ $tanggalVerifikasiKD }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-header py-3 d-flex align-items-center">
                            <i class="fas fa-history font-weight-bold"></i>
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
                                        style="color: #1f1f1f; width: 300px;" value="{{ $namaKaryawanMK }}" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-1  row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                    Pengajuan
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="nama_status_pengajuan_mk" name="nama_status_pengajuan_mk"
                                        style="color: #1f1f1f; width: 300px;"
                                        value="{{ $reimbursement->nama_status_pengajuan_mk ?: '-' }}" readonly>
                                </div>
                            </div>

                            @if ($reimbursement->id_status_pengajuan_mk == 8)
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Total
                                        Disetujui</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext mb-1"
                                            aria-describedby="total_setuju_mk" name="total_setuju_mk"
                                            style="color: #1f1f1f; width: 300px;"
                                            value="{{ $reimbursement->total_setuju_mk ? 'Rp. ' . number_format($reimbursement->total_setuju_mk, 2, '.', ',') : '-' }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif

                            @if ($reimbursement->id_status_pengajuan_mk == 35)
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Alasan
                                        Revisi
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control-plaintext mb-1" aria-describedby="alasan_revisi_mk" name="alasan_revisi_mk"
                                            style="color: #1f1f1f; width: 300px;" readonly>{{ $reimbursement->alasan_revisi_mk ?: '-' }}</textarea>
                                    </div>
                                </div>
                            @endif


                            @if ($reimbursement->id_status_pengajuan_mk == 9)
                                <div class="form-group mb-1 row">
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Alasan
                                        Tolak

                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control-plaintext mb-1" aria-describedby="alasan_ditolak_mk " name="alasan_ditolak_mk"
                                            style="color: #1f1f1f; width: 300px;" readonly>{{ $reimbursement->alasan_ditolak_mk ?: '-' }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group mb-1 row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
                                    Verifikasi</label>
                                <div class="col-sm-9">
                                    @php
                                        $tanggalVerifikasiMK = !empty($reimbursement->tanggal_verifikasi_mk)
                                            ? \Carbon\Carbon::parse($reimbursement->tanggal_verifikasi_mk)
                                                ->locale('id')
                                                ->isoFormat('DD MMMM YYYY HH:mm:ss')
                                            : '-';
                                    @endphp
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="tanggal_verifikasi_mk" name="tanggal_verifikasi_mk"
                                        style="color: #1f1f1f; width: 300px;" value="{{ $tanggalVerifikasiMK }}"
                                        readonly>
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
                                        style="color: #1f1f1f; width: 300px;" value="{{ $namaKaryawanSK }}" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-1  row">
                                <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                                    Pengajuan
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext mb-1"
                                        aria-describedby="nama_status_pengajuan_sk" name="nama_status_pengajuan_sk"
                                        style="color: #1f1f1f;"
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
                                    <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
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
                                            style="color: #1f1f1f; width: 300px;" value="{{ $tanggalVerifikasiSK }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
