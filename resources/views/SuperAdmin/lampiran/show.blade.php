<div class="modal fade" id="showLampiranModal-{{ $lampiran->id_lampiran }}" tabindex="-1" role="dialog"
    aria-labelledby="showLampiranLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('lampiran.update', $lampiran->id_lampiran) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showLampiranLabel" style="color: white;">Detail Lampiran</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Reimbursement</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="id_reimbursement"
                                name="id_reimbursement" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->id_reimbursement }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nomor Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nomor_kwitansi"
                                name="nomor_kwitansi" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->nomor_kwitansi }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Judul Lampiran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="judul_kwitansi"
                                name="judul_kwitansi" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->judul_kwitansi}}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_kwitansi"
                                name="nama_kwitansi" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->nama_kwitansi}}" readonly>
                        </div>
                    </div>



                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">
                            Reimbursement</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1"
                                aria-describedby="jenis_reimbursement" name="jenis_reimbursement"
                                style="color: #1f1f1f; width: 300px;" value="{{ $lampiran->nama_jenis_reimbursement }}"
                                readonly>
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="supplier"
                                name="supplier" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->nama_supplier}}" readonly>
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">File</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="file" name="file"
                                style="color: #1f1f1f; width: 300px;" value="{{ $lampiran->file}}" readonly>
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="keterangan"
                                name="keterangan" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->keterangan}}" readonly>
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Tanggal
                            Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="tanggal_kwitansi"
                                name="tanggal_kwitansi" style="color: #1f1f1f; width: 300px;"
                                value="{{ $lampiran->tanggal_kwitansi}}" readonly>
                        </div>
                    </div>













                </div>
            </div>
        </div>
    </form>
</div>