<!-- Modal -->
<div class="modal fade editModal" id="editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}" tabindex="-1"
    role="dialog" aria-labelledby="editModalLabel{{ $reimbursement->id_reimbursement }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="editModalLabel{{ $reimbursement->id_reimbursement }}" style="color: white;">
                    Edit
                    Status Pengajuan - {{ $reimbursement->nama_jenis_reimbursement }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="{{ route('medical-verifikasi-mk.update', $reimbursement->id_reimbursement) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="id_status_pengajuan_mk" class="col-form-label">Status Pengajuan</label>
                        {{-- <div class="col-sm-9"> --}}
                        <select class="form-control" id="id_status_pengajuan_mk" name="id_status_pengajuan_mk">
                            @foreach ($status_pengajuans as $status_pengajuan)
                                <option value="{{ $status_pengajuan->id_status_pengajuan }}"
                                    @if ($status_pengajuan->id_status_pengajuan == $reimbursement->id_status_pengajuan) selected @endif>
                                    {{ $status_pengajuan->nama_status_pengajuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_status_pengajuan_mk')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- </div> --}}
                    </div>

                    <div class="form-group mb-3" id="form-total-reimbursement">
                        <label for="total" class="col-form-label">Total Reimbursement</label>
                        <input class="form-control" id="total" name="total"
                            value="{{ number_format($reimbursement->total, 0, ',', '.') }}" readonly>
                        @error('total')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- <div class="form-group mb-3" id="form-total-setuju">
                        <label for="total_setuju_mk" class="col-form-label">Total Disetujui</label>
                        <input class="form-control" id="total_setuju_mk" name="total_setuju_mk"
                            value="{{ number_format($reimbursement->total_setuju_mk, 0, ',', '.') }}"
                            data-max="{{ $reimbursement->total }}">
                        @error('total_setuju_mk')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}


                    <div class="form-group mb-3" id="form-total-setuju">
                        <label for="total_setuju_mk" class="col-form-label">Total Disetujui</label>
                        <input class="form-control" id="total_setuju_mk" name="total_setuju_mk"
                            value="{{ ltrim(number_format($reimbursement->total_setuju_mk, 0, ',', '.'), '0') }}">
                        @error('total_setuju_mk')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="form-group mb-3" id="form-alasan-revisi">
                        <label for="" class="col-form-label">Alasan Revisi</label>
                        {{-- <div class="col-sm-9"> --}}
                        <textarea class="form-control" id="alasan_revisi_mk" name="alasan_revisi_mk" rows="3">{{ $reimbursement->alasan_revisi_mk }}</textarea>
                        @error('alasan_revisi_mk')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- </div> --}}
                    </div>

                    <div class="form-group mb-3" id="form-alasan-ditolak">
                        <label for="" class="col-form-label">Alasan Ditolak</label>
                        {{-- <div class="col-sm-9"> --}}
                        <textarea class="form-control" id="alasan_ditolak_mk" name="alasan_ditolak_mk" rows="3">{{ $reimbursement->alasan_ditolak_mk }}</textarea>
                        @error('alasan_ditolak_mk')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- </div --}}
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
    var totalInputs = document.querySelectorAll('#total_setuju_mk');
    totalInputs.forEach(function(totalInput) {
        totalInput.addEventListener('keyup', function(e) {
            totalInput.value = formatRupiah(this.value);
        });
    });

    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString();
        var split = number_string.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        return rupiah;
    }
</script>


{{-- <script>
    var totalInput = document.getElementById('total_setuju_mk');
    var maxValue = parseInt(totalInput.getAttribute('data-max'));

    totalInput.addEventListener('input', function(e) {
        var angka = this.value.replace(/\./g, '').replace(/,/g, '');

        if (angka > maxValue) {
            // Angka melebihi nilai maksimum
            this.value = formatRupiah(maxValue.toString());
            var errorMessage = document.createElement('span');
            errorMessage.classList.add('text-danger');
            errorMessage.innerHTML =
                'Inputan tidak boleh melebihi total reimbursement "{{ number_format($reimbursement->total, 0, ',', '.') }}"!';
            this.parentNode.appendChild(errorMessage);
        } else {
            this.value = formatRupiah(angka);
            var errorMessage = this.parentNode.querySelector('.text-danger');
            if (errorMessage) {
                this.parentNode.removeChild(errorMessage);
            }
        }
    });

    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString();
        var split = number_string.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        return rupiah;
    }
</script> --}}





<script>
    function setupFormDisplay(modal) {
        var statusPengajuanSelect = modal.querySelector(".form-control");
        var alasanRevisiForm = modal.querySelector("#form-alasan-revisi");
        var alasanDitolakForm = modal.querySelector("#form-alasan-ditolak");
        var totalSetujuForm = modal.querySelector("#form-total-setuju");
        var totalReimForm = modal.querySelector("#form-total-reimbursement");

        // Inisialisasi tampilan form
        if (statusPengajuanSelect.value == 9) {
            alasanDitolakForm.style.display = "block";
            alasanRevisiForm.style.display = "none";
            totalSetujuForm.style.display = "none";
            totalReimForm.style.display = "none";
        } else if (statusPengajuanSelect.value == 35) {
            alasanRevisiForm.style.display = "block";
            alasanDitolakForm.style.display = "none";
            totalSetujuForm.style.display = "none";
            totalReimForm.style.display = "none";
        } else if (statusPengajuanSelect.value == 8) {
            alasanRevisiForm.style.display = "none"
            alasanDitolakForm.style.display = "none";
            totalSetujuForm.style.display = "block";
            totalReimForm.style.display = "block";
        } else {
            alasanRevisiForm.style.display = "none";
            alasanDitolakForm.style.display = "none";
            totalSetujuForm.style.display = "none";
            totalReimForm.style.display = "none";
        }

        // Tambahkan event listener untuk mengubah tampilan form saat dropdown berubah
        statusPengajuanSelect.addEventListener("change", function() {
            if (statusPengajuanSelect.value == 9) {
                alasanDitolakForm.style.display = "block";
                alasanRevisiForm.style.display = "none";
                totalSetujuForm.style.display = "none";
                totalReimForm.style.display = "none";
            } else if (statusPengajuanSelect.value == 35) {
                alasanRevisiForm.style.display = "block";
                alasanDitolakForm.style.display = "none";
                totalSetujuForm.style.display = "none";
                totalReimForm.style.display = "none";
            } else if (statusPengajuanSelect.value == 8) {
                alasanRevisiForm.style.display = "none"
                alasanDitolakForm.style.display = "none";
                totalSetujuForm.style.display = "block";
                totalReimForm.style.display = "block";
            } else {
                alasanRevisiForm.style.display = "none";
                alasanDitolakForm.style.display = "none";
                totalSetujuForm.style.display = "none";
                totalReimForm.style.display = "none";
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
