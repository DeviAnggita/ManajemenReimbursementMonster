<!-- Modal -->
<div class="modal fade" id="editModalJenisReimbursement{{$jenisreimbursement->id_jenis_reimbursement}}" tabindex="-1"
    role="dialog" aria-labelledby="editModalLabel{{$jenisreimbursement->id_jenis_reimbursement}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{$jenisreimbursement->id_jenis_reimbursement}}"
                    style="color: white;">
                    Edit - {{$jenisreimbursement->nama_jenis_reimbursement}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST"
                    action="{{route('jenisreimbursement.update', $jenisreimbursement->id_jenis_reimbursement)}}">
                    @csrf
                    @method('PUT')
                    {{-- <div class="form-group mb-3 row">
                        <label for="memiliki_supplier" class="col-sm-4 col-form-label">Supplier</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="memiliki_supplier" name="memiliki_supplier">
                                <option value="0" {{ $jenisreimbursement->memiliki_supplier == 0 ? 'selected' : ''
                                    }}>Tidak
                                    memiliki
                                    supplier</option>
                                <option value="1" {{ $jenisreimbursement->memiliki_supplier == 1 ? 'selected' : ''
                                    }}>Memiliki
                                    supplier</option>
                            </select>
                            @error('memiliki_supplier')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> --}}


                    <div class="form-group mb-3 row">
                        <label for="nama_jenis_reimbursement" class="col-sm-4 col-form-label">Nama Jenis
                            Reimbursement</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama_jenis_reimbursement"
                                name="nama_jenis_reimbursement"
                                value="{{$jenisreimbursement->nama_jenis_reimbursement}}">
                            @error('nama_jenis_reimbursement')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
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