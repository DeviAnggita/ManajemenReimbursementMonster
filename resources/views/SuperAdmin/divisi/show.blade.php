<div class="modal fade" id="showDivisiModal-{{ $divisi->id_divisi }}" tabindex="-1" role="dialog"
    aria-labelledby="showDivisiLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('divisi.update', $divisi->id_divisi) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showDivisiLabel" style="color: white;">Detail Divisi</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama Divisi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_divisi"
                                name="nama_divisi" style="color: #1f1f1f; width: 300px;"
                                value="{{ $divisi->nama_divisi }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>