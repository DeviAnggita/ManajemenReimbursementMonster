<!-- Modal -->
<div class="modal fade" id="editModalStrata{{ $strata->id_strata }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $strata->id_strata }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{ $strata->id_strata }}" style="color: white;">
                    Edit
                    Strata - {{ $strata->nama_strata }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('strata.update', $strata->id_strata) }}">
                    @csrf
                    @method('PUT')


                    <div class="modal-body" style="color: black;">
                        <div class="form-group mb-1 row">
                            <label for="nama_divisi_update" class="col-sm-3 col-form-label">Nama Strata</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_strata" name="nama_strata"
                                    value="{{ $strata->nama_strata }}">
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
                            <label for="status_active_update" class="col-sm-4 col-form-label">Status Active</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1"
                                        name="status_active" {{ $strata->status_active == 1 ? 'checked' : '' }}>
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
