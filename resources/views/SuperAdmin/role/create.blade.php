<div class="modal fade" id="tambahDataRoleModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataRoleLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataRoleLabel" style="color: white;">Tambah Role</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label for="nama_role_create" class="col-sm-3 col-form-label">Nama Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nama_role') is-invalid @enderror mb-1"
                                id="nama_role_create" aria-describedby="nama_role" name="nama_role"
                                value="{{ old('nama_role') }}" required>
                            @error('nama_role')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label for="status_active_create" class="col-sm-3 col-form-label">Status Active</label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1"
                                    name="status_active" checked>
                            </div>
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
