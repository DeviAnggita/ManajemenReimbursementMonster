<!-- Modal -->
<div class="modal fade" id="editModalRole{{ $role->id_role }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $role->id_role }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{ $role->id_role }}" style="color: white;">
                    Edit
                    Role - {{ $role->nama_role }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('role.update', $role->id_role) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body" style="color: black;">
                        <div class="form-group mb-1 row">
                            <label for="nama_role" class="col-sm-3 col-form-label">Nama Role</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_role" name="nama_role"
                                    value="{{ $role->nama_role }}">
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
                            <label for="status_active_update" class="col-sm-4 col-form-label">Status Active</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1"
                                        name="status_active" {{ $role->status_active == 1 ? 'checked' : '' }}>
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
