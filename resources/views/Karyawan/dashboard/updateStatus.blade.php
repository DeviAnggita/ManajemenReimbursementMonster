<!-- Modal -->
<div class="modal fade" id="editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $reimbursement->id_reimbursement }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{ $reimbursement->id_reimbursement }}" style="color: white;">
                    Edit
                    Status Pengajuan - {{ $reimbursement->nama_jenis_reimbursement }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kdashboard.updateStatus', $reimbursement->id_reimbursement) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3 row">
                        <label for="id_status_pengajuan" class="col-sm-3 col-form-label">Status Pengajuan</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="id_status_pengajuan" name="id_status_pengajuan">
                                @foreach ($status_pengajuans as $status_pengajuan)
                                    <option value="{{ $status_pengajuan->id_status_pengajuan }}"
                                        @if ($status_pengajuan->id_status_pengajuan == $reimbursement->id_status_pengajuan) selected @endif>
                                        {{ $status_pengajuan->nama_status_pengajuan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_status_pengajuan')
                                <div class="alert alert-danger">{{ $message }}</div>
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
