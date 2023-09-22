<div class="modal fade" id="showStatusPengajuanModal-{{ $statuspengajuan->id_status_pengajuan }}" tabindex="-1"
    role="dialog" aria-labelledby="showStatusPengajuanLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('status-pengajuan.update', $statuspengajuan->id_status_pengajuan) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showStatusPengajuanLabel" style="color: white;">Detail Status Pengajuan
                    </h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_role"
                                name="nama_role" style="color: #1f1f1f; width: 300px;"
                                value="{{ $statuspengajuan->nama_role }}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Status
                            Pengajuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1"
                                aria-describedby="nama_status_pengajuan" name="nama_status_pengajuan"
                                style="color: #1f1f1f; width: 300px;"
                                value="{{ $statuspengajuan->nama_status_pengajuan}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>