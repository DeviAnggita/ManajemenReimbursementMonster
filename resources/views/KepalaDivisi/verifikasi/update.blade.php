<!-- Modal -->
<div class="modal fade editModal" id="editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}" tabindex="-1"
    role="dialog" aria-labelledby="editModalLabel{{ $reimbursement->id_reimbursement }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="editModalLabel{{ $reimbursement->id_reimbursement }}" style="color: white;">
                    Edit
                    Status Pengajuan - {{ $reimbursement->nama_jenis_reimbursement }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('verifikasi-kd.update', $reimbursement->id_reimbursement) }}">
                    @csrf
                    @method('PUT')


                    <div class="form-group mb-3">
                        <label for="id_status_pengajuan" class="col-form-label">Status Pengajuan</label>
                        {{-- <div class="col-sm-9"> --}}
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
                        {{-- </div> --}}
                    </div>


                    <div class="form-group mb-3" style="width:100% display:none" id="form-alasan-revisi">
                        <label for="alasan_revisi_kd" class="col-form-label">Alasan Revisi</label>
                        {{-- <div class="col-sm-9"> --}}
                        <textarea class="form-control" id="alasan_revisi_kd" name="alasan_revisi_kd" rows="2">{{ $reimbursement->alasan_revisi_kd }}</textarea>
                        @error('alasan_revisi_kd')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- </div> --}}
                    </div>

                    <div class="form-group mb-3" style="width:100% display:none" id="form-alasan-ditolak">
                        <label for="alasan_ditolak_kd" class="col-form-label">Alasan Ditolak</label>
                        {{-- <div class="col-sm-9"> --}}
                        <textarea class="form-control" id="alasan_ditolak_kd" name="alasan_ditolak_kd" rows="2">{{ $reimbursement->alasan_ditolak_kd }}</textarea>
                        @error('alasan_ditolak_kd')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- </div> --}}
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


<script>
    function setupFormDisplay(modal) {
        var statusPengajuanSelect = modal.querySelector(".form-control");
        var alasanRevisiForm = modal.querySelector("#form-alasan-revisi");
        var alasanDitolakForm = modal.querySelector("#form-alasan-ditolak");

        // Inisialisasi tampilan form
        if (statusPengajuanSelect.value == 11) {
            alasanRevisiForm.style.display = "none";
            alasanDitolakForm.style.display = "block";
        } else if (statusPengajuanSelect.value == 34) {
            alasanRevisiForm.style.display = "block";
            alasanDitolakForm.style.display = "none";
        } else {
            alasanRevisiForm.style.display = "none";
            alasanDitolakForm.style.display = "none";
        }

        // Tambahkan event listener untuk mengubah tampilan form saat dropdown berubah
        statusPengajuanSelect.addEventListener("change", function() {
            if (statusPengajuanSelect.value == 11) {
                alasanRevisiForm.style.display = "none";
                alasanDitolakForm.style.display = "block";
            } else if (statusPengajuanSelect.value == 34) {
                alasanRevisiForm.style.display = "block";
                alasanDitolakForm.style.display = "none";
            } else {
                alasanRevisiForm.style.display = "none";
                alasanDitolakForm.style.display = "none";
            }
        });
    }

    // Ambil semua elemen modal dengan class "editModal"
    var modals = document.querySelectorAll(".editModal");

    // Iterasi melalui setiap modal dan atur tampilan form
    modals.forEach(function(modal) {
        setupFormDisplay(modal);
    });
</script>
