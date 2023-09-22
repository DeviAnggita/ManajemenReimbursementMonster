@foreach($statuspengajuans as $statuspengajuan)
<div class="modal fade" id="deleteModalStatusPengajuan{{ $statuspengajuan->id_status_pengajuan }}" tabindex="-1"
    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Data Status Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data status pengajuan "{{ $statuspengajuan->nama_status_pengajuan
                }}" dengan role "{{ $statuspengajuan->nama_role
                }}"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <form action="{{ route('status-pengajuan.destroy', $statuspengajuan->id_status_pengajuan) }}"
                    method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach