<div class="modal fade" id="showKaryawanModal-{{ $karyawan->id_user }}" tabindex="-1" role="dialog"
    aria-labelledby="showKaryawanLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('karyawan.update', $karyawan->id_user) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showKaryawanLabel" style="color: white;">Detail Karyawan</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row  d-flex ">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">No.
                            Identitas </label>
                        <div class="col-sm-9 mb-1">
                            <input type="text" name="nomor_identitas_karyawan" class="form-control-plaintext mb-1"
                                aria-describedby="nomor_identitas_karyawan" style="color: #1f1f1f; width: 300px;"
                                value="{{ $karyawan->nomor_identitas_karyawan }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">

                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_karyawan"
                                name="nama_karyawan" style="color: #1f1f1f; width: 300px;"
                                value="{{ $karyawan->nama_karyawan }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Divisi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_divisi"
                                name="nama_divisi" style="color: #1f1f1f; width: 300px;"
                                value="{{ $karyawan->nama_divisi }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Strata</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_strata"
                                name="nama_strata" style="color: #1f1f1f; width: 300px;"
                                value="{{ $karyawan->nama_strata }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control-plaintext mb-1" aria-describedby="email_karyawan"
                                name="email_karyawan" style="color: #1f1f1f; width: 300px;"
                                value="{{ $karyawan->email_karyawan }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Gaji
                            (Rp.)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="gaji" name="gaji"
                                style="color: #1f1f1f; width: 300px;" value="{{ $karyawan->gaji }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_role"
                                name="nama_role" style="color: #1f1f1f; width: 300px;"
                                value="{{ $karyawan->nama_role }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>