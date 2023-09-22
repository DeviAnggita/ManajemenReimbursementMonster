<div class="modal fade" id="tambahDataJenisReimbursementModal" tabindex="-1" role="dialog"
    aria-labelledby="tambahDataJenisReimbursementLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('jenisreimbursement.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataJenisReimbursementLabel" style="color: white;">Tambah Jenis
                        Reimbursement
                    </h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="color: black;">
                    {{-- <div class="form-group mb-3 row">
                        <label for="memiliki_supplier_create" class="col-sm-4 col-form-label">Supplier</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="memiliki_supplier" name="memiliki_supplier">
                                <option value="">-- Supplier --</option>
                                <option value="0">Tidak memiliki supplier</option>
                                <option value="1">Memiliki supplier</option>
                            </select>
                            @error('memiliki_supplier')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="form-group mb-1 row">
                        <label for="nama_jenis_reimbursement_create" class="col-sm-4 col-form-label">Nama Jenis
                            Reimbursement</label>
                        <div class="col-sm-8">
                            <input type="text"
                                class="form-control @error('nama_jenis_reimbursement') is-invalid @enderror mb-1"
                                id="nama_jenis_reimbursement_create" aria-describedby="nama_jenis_reimbursement"
                                name="nama_jenis_reimbursement" value="{{ old('nama_jenis_reimbursement') }}" required>
                            @error('nama_jenis_reimbursement')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
                </div>


            </div>
        </div>
    </form>
</div>