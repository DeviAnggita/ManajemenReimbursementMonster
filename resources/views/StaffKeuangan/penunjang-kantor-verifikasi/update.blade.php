<!-- Modal -->
<div class="modal fade editModal" id="editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}" tabindex="-1"
    role="dialog" aria-labelledby="editModalLabel{{ $reimbursement->id_reimbursement }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #189E6F;">
                <h5 class="modal-title" id="editModalLabel{{ $reimbursement->id_reimbursement }}" style="color: white;">
                    Edit
                    Status Pengajuan - {{ $reimbursement->nama_jenis_reimbursement }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="{{ route('penunjang-kantor-verifikasi-sk.update', $reimbursement->id_reimbursement) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="col-form-label">Total Disetujui</label>
                        <input type="text" class="form-control" aria-describedby="total_setuju_mk"
                            name="total_setuju_mk"
                            value="{{ $reimbursement->total_setuju_mk ? 'Rp. ' . number_format($reimbursement->total_setuju_mk, 2, ',', '.') : '-' }}"
                            readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_status_pengajuan_sk" class="col-form-label">Status Pengajuan</label>
                        <div class="form-check">
                            <input type="hidden" name="id_status_pengajuan_sk" value="46">
                            <!-- Add a hidden field for unchecked state -->
                            <input type="checkbox" id="id_status_pengajuan_sk" name="id_status_pengajuan_sk"
                                value="45" class="form-check-input"
                                {{ $reimbursement->id_status_pengajuan_sk == 45 ? 'checked' : '' }}>
                            <label class="form-check-label" for="id_status_pengajuan_sk">
                                Sudah Terbayar Reimburse
                            </label>
                        </div>
                        @error('id_status_pengajuan_sk')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- <div class="form-group mb-3" id="form-total-dibayar_sk">
                        <label for="total_dibayar_sk" class="col-form-label">Total Dibayar</label>
                        <input class="form-control" id="total_dibayar_sk" name="total_dibayar_sk"
                            value="{{ ltrim(number_format($reimbursement->total_dibayar_sk, 0, ',', '.'), '0') }}"
                            data-max="{{ $reimbursement->total_setuju_mk }}" required>
                        @error('total_dibayar_sk')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}

                    <div class="form-group mb-3" id="form-total-dibayar_sk">
                        <label for="total_dibayar_sk" class="col-form-label">Total Dibayar</label>
                        <input class="form-control" id="total_dibayar_sk" name="total_dibayar_sk"
                            value="{{ ltrim(number_format($reimbursement->total_setuju_mk, 0, ',', '.'), '0') }}"
                            required>
                        @error('total_dibayar_sk')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    <div class="form-group mb-3">
                        <label for="file_dibayar_sk" class="col-form-label">File (.png, .jpeg, .jpg)</label>
                        <input type="file" id="file_dibayar_sk" name="file_dibayar_sk" class="form-control mb-1"
                            accept=".png, .jpeg, .jpg" required>
                        @error('file_dibayar_sk')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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
    var totalInputs = document.querySelectorAll('[id^="total_dibayar_sk"]');
    var errorMessage = document.createElement('span');
    errorMessage.classList.add('text-danger');
    errorMessage.innerHTML =
        'Inputan tidak boleh melebihi total reimbursement "{{ number_format($reimbursement->total, 0, ',', '.') }}"!';

    totalInputs.forEach(function(totalInput) {
        var maxValue = parseInt(totalInput.getAttribute('data-max'));
        var errorDisplayed = false;

        totalInput.addEventListener('input', function(e) {
            var angka = this.value.replace(/\./g, '').replace(/,/g, '');

            if (angka > maxValue && !errorDisplayed) {
                // Angka melebihi nilai maksimum
                this.value = formatRupiah(maxValue.toString());
                this.parentNode.appendChild(errorMessage);
                errorDisplayed = true;
            } else if (angka <= maxValue && errorDisplayed) {
                this.parentNode.removeChild(errorMessage);
                errorDisplayed = false;
            }

            this.value = formatRupiah(angka);
        });
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
</script>
