<div class="modal fade" id="showRoleModal-{{ $role->id_role }}" tabindex="-1" role="dialog"
    aria-labelledby="showRoleLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('role.update', $role->id_role) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showRoleLabel" style="color: white;">
                        Detail Role</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_role"
                                name="nama_role" style="color: #1f1f1f; width: 300px;" value="{{ $role->nama_role}}"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>