<!-- Modal -->
<div class="modal fade" id="editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $reimbursement->id_reimbursement }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editModalLabel{{ $reimbursement->id_reimbursement }}" style="color: white;">
                    Edit
                    Status Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kmedical.updateStatus', $reimbursement->id_reimbursement) }}">
                    @csrf
                    @method('PUT')

                    @if (
                        !empty($reimbursement->total_setuju_mk) &&
                            ($reimbursement->id_status_pengajuan_mk == 8 ||
                                $reimbursement->id_status_pengajuan_ky == 17 ||
                                $reimbursement->id_status_pengajuan_ky == 6 ||
                                $reimbursement->id_status_pengajuan_ky == 5 ||
                                $reimbursement->id_status_pengajuan_mk == 17 ||
                                $reimbursement->id_status_pengajuan_mk == 6 ||
                                $reimbursement->id_status_pengajuan_mk == 5))
                        <div class="form-group mb-3 row">
                            <label class="col-sm-3 col-form-label">Total
                                Disetujui</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control-plaintext mb-1"
                                    aria-describedby="id_reimbursement" name="id_reimbursement"
                                    value="{{ number_format($reimbursement->total_setuju_mk, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                    @endif

                    <div class="form-group mb-3 row">
                        <label for="id_status_pengajuan_ky" class="col-sm-3 col-form-label">Status Pengajuan</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="id_status_pengajuan_ky" name="id_status_pengajuan_ky"
                                required>
                                @foreach ($status_pengajuans as $status_pengajuan)
                                    <option value="{{ $status_pengajuan->id_status_pengajuan }}"
                                        {{ $status_pengajuan->id_status_pengajuan == $reimbursement->id_status_pengajuan ? 'selected' : '' }}>
                                        {{ $status_pengajuan->nama_status_pengajuan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_status_pengajuan_ky')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row" id="form-total-pembayaran-diterima">
                        <label for="total_pembayaran_diterima" class="col-sm-3 col-form-label">Total Diterima</label>
                        <div class="col-sm-9">
                            @php
                                $total_pembayaran_diterima = $reimbursement->total_pembayaran_diterima ?? $reimbursement->total_setuju_mk;
                                $formatted_total = ltrim(number_format($total_pembayaran_diterima, 0, ',', '.'), '0');
                            @endphp
                            <input class="form-control" id="total_pembayaran_diterima" name="total_pembayaran_diterima"
                                value="{{ $formatted_total }}" required>
                            @error('total_pembayaran_diterima')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>



                    <script>
                        var totalInput = document.getElementById('total_pembayaran_diterima');
                        totalInput.addEventListener('keyup', function(e) {
                            totalInput.value = formatRupiah(this.value);
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


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
