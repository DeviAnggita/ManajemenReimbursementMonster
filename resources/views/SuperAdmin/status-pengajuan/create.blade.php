<div class="modal fade" id="tambahDataStatusPengajuanModal" tabindex="-1" role="dialog"
    aria-labelledby="tambahDataStatusPengajuanLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('status-pengajuan.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataStatusPengajuanLabel" style="color: white;">Tambah Status
                        Pengajuan</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label for="id_role_create" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select name="id_role" id="id_role_create" class="form-control mb-1 shadow-none" required>
                                <option disabled selected="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id_role }}">
                                        {{ $role->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_role')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label for="nama_status_pengajuan_create" class="col-sm-3 col-form-label">Nama Status
                            Pengajuan</label>
                        <div class="col-sm-9">
                            <input type="text"
                                class="form-control @error('nama_status_pengajuan') is-invalid @enderror mb-1"
                                id="nama_status_pengajuan_create" aria-describedby="nama_status_pengajuan"
                                name="nama_status_pengajuan" value="{{ old('nama_status_pengajuan') }}" required>
                            @error('nama_status_pengajuan')
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
