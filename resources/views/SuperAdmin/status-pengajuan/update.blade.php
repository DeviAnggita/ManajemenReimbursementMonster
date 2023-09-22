<!-- Modal -->
<div class="modal fade" id="editModalStatusPengajuan{{ $statuspengajuan->id_status_pengajuan }}" tabindex="-1"
    role="dialog" aria-labelledby="editModalLabel{{ $statuspengajuan->id_status_pengajuan }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{ $statuspengajuan->id_status_pengajuan }}"
                    style="color: white;">
                    Edit
                    Status Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST"
                    action="{{ route('status-pengajuan.update', $statuspengajuan->id_status_pengajuan) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body" style="color: black;">
                        <div class="form-group mb-3 row">
                            <label for="role" class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="role" name="id_role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id_role }}"
                                            @if ($statuspengajuan->id_role == $role->id_role) selected @endif>{{ $role->nama_role }}
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
                        <div class="form-group mb-3 row">
                            <label for="nama_status_pengajuan" class="col-sm-3 col-form-label">Status Pengajuan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_status_pengajuan"
                                    name="nama_status_pengajuan" value="{{ $statuspengajuan->nama_status_pengajuan }}">
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
                            <label for="status_active_update" class="col-sm-4 col-form-label">Status Active</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1"
                                        name="status_active"
                                        {{ $statuspengajuan->status_active == 1 ? 'checked' : '' }}>
                                    @error('status_active')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
