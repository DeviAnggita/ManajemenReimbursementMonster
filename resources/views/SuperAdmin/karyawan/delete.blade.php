@foreach ($karyawans as $karyawan)
    <div class="modal fade" id="deleteModalKaryawan{{ $karyawan->id_user }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Data Strata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data karyawan "{{ $karyawan->nama_karyawan }}"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <form action="{{ route('karyawan.destroy', $karyawan->id_user) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
