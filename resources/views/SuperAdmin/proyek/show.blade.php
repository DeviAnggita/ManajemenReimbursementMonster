<div class="modal fade" id="showProyekModal-{{ $proyek->id_proyek }}" tabindex="-1" role="dialog"
    aria-labelledby="showProyekLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('proyek.update', $proyek->id_proyek) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showProyekLabel" style="color: white;">Detail Proyek</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-4 col-form-label" style="color: black; width: 25%;">Nomor Proyek</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nomor_proyek"
                                name="nomor_proyek" style="color: #1f1f1f; width: 300px;"
                                value="{{ $proyek->nomor_proyek }}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-1 row">
                        <label class="col-sm-4 col-form-label" style="color: black; width: 25%;">Nama Proyek</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_proyek"
                                name="nama_proyek" style="color: #1f1f1f; width: 300px;"
                                value="{{ $proyek->nama_proyek }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>