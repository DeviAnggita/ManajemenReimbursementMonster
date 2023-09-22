<div class="modal fade" id="tambahDataProyekModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataProyekLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('proyek.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataProyekLabel" style="color: white;">Tambah Proyek</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label for="nomor_proyek_create" class="col-sm-3 col-form-label">Nomor Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nomor_proyek') is-invalid @enderror mb-1"
                                id="nomor_proyek_create" aria-describedby="nomor_proyek" name="nomor_proyek"
                                value="{{ old('nomor_proyek') }}" required>
                            @error('nomor_proyek')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-1 row">
                        <label for="nama_proyek_create" class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nama_proyek') is-invalid @enderror mb-1"
                                id="nama_proyek_create" aria-describedby="nama_proyek" name="nama_proyek"
                                value="{{ old('nama_proyek') }}" required>
                            @error('nama_proyek')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
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
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
