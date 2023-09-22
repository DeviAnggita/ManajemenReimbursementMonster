<div class="modal fade" id="showJenisReimbursementModal-{{ $jenisreimbursement->id_jenis_reimbursement }}" tabindex="-1"
    role="dialog" aria-labelledby="showJenisReimbursementLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('jenisreimbursement.update', $jenisreimbursement->id_jenis_reimbursement) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showJenisReimbursementLabel" style="color: white;">Detail Jenis
                        Reimbursement</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-2 row">
                        <label class="col-sm-4 col-form-label" style="color: black; width: 25%;">Supplier</label>
                        <div class="col-sm-8">
                            @if ($jenisreimbursement->memiliki_supplier == 0)
                            <input type="text" class="form-control-plaintext mb-1"
                                aria-describedby="tidak_memiliki_supplier" name="tidak_memiliki_supplier"
                                style="color: #1f1f1f; width: 300px;" value="Tidak memiliki supplier" readonly>
                            @else
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="memiliki_supplier"
                                name="memiliki_supplier" style="color: #1f1f1f; width: 300px;"
                                value="{{ $jenisreimbursement->memiliki_supplier}}" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <label class="col-sm-4 col-form-label" style="color: black; width: 25%;">Proyek</label>
                        <div class="col-sm-8">
                            @if ($jenisreimbursement->memiliki_proyek == 0)
                            <input type="text" class="form-control-plaintext mb-1"
                                aria-describedby="tidak_memiliki_proyek" name="tidak_memiliki_proyek"
                                style="color: #1f1f1f; width: 300px;" value="Tidak memiliki proyek" readonly>
                            @else
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="memiliki_proyek"
                                name="memiliki_proyek" style="color: #1f1f1f; width: 300px;"
                                value="{{ $jenisreimbursement->memiliki_proyek}}" readonly>
                            @endif
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label class="col-sm-4 col-form-label" style="color: black; width: 25%;">Nama Jenis
                            Reimbursement</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext mb-1"
                                aria-describedby="nama_jenis_reimbursement" name="nama_jenis_reimbursement"
                                style="color: #1f1f1f; width: 300px;"
                                value="{{ $jenisreimbursement->nama_jenis_reimbursement}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>