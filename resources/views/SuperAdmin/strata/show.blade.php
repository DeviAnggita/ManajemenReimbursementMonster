<div class="modal fade" id="showStrataModal-{{ $strata->id_strata }}" tabindex="-1" role="dialog"
    aria-labelledby="showStrataLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('strata.update', $strata->id_strata) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showStrataLabel" style="color: white;">Detail Strata</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama Strata</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_strata"
                                name="nama_strata" style="color: #1f1f1f; width: 300px;"
                                value="Strata {{ $strata->nama_strata }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>