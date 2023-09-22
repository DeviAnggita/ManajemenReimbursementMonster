<div class="modal fade" id="tambahDataStrataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataStrataLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('strata.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataStrataLabel" style="color: white;">Tambah Strata</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label for="nama_strata_create" class="col-sm-3 col-form-label">Nama Strata</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nama_strata') is-invalid @enderror mb-1"
                                id="nama_strata_create" aria-describedby="nama_strata" name="nama_strata"
                                value="{{ old('nama_strata') }}" required>
                            @error('nama_strata')
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
