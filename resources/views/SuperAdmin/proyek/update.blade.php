<!-- Modal -->
<div class="modal fade" id="editModalProyek{{ $proyek->id_proyek }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $proyek->id_proyek }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{ $proyek->id_proyek }}" style="color: white;">
                    Edit
                    Proyek - {{ $proyek->nama_proyek }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('proyek.update', $proyek->id_proyek) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body" style="color: black;">
                        <div class="form-group mb-1 row">
                            <label for="nomor_proyek" class="col-sm-3 col-form-label">Nomor Proyek</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nomor_proyek" name="nomor_proyek"
                                    value="{{ $proyek->nomor_proyek }}">
                                @error('nomor_proyek')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>




                    <div class="modal-body" style="color: black;">
                        <div class="form-group mb-1 row">
                            <label for="nama_proyek" class="col-sm-3 col-form-label">Nama Proyek</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_proyek" name="nama_proyek"
                                    value="{{ $proyek->nama_proyek }}">
                                @error('nama_proyek')
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
                                        name="status_active" {{ $proyek->status_active == 1 ? 'checked' : '' }}>
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
