<div class="modal fade" id="tambahDataKaryawanModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataKaryawanLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataKaryawanLabel" style="color: white;">Tambah Karyawan</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="color: black;">

                    <div class="form-group mb-1 row">
                        <label for="nomor_identitas_karyawan_create" class="col-sm-3 col-form-label">No.
                            Identitas</label>
                        <div class="col-sm-9 mb-1">
                            <input type="number" name="nomor_identitas_karyawan"
                                class="form-control 
                                                    @error('nomor_identitas_karyawan') is-invalid @enderror mb-1"
                                id="nomor_identitas_karyawan_create" aria-describedby="nomor_identitas_karyawan"
                                value="{{ old('nomor_identitas_karyawan') }}" placeholder="Masukkan Nomor Identitas"
                                required>
                            @error('nomor_identitas_karyawan')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="nama_karyawan_create" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror mb-1"
                                id="nama_karyawan_create" aria-describedby="nama_karyawan" name="nama_karyawan"
                                value="{{ old('nama_karyawan') }}" required>
                            @error('nama_karyawan')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="id_divisi_create" class="col-sm-3 col-form-label">Divisi</label>
                        <div class="col-sm-9">
                            <select name="id_divisi" id="id_divisi_create" class="form-control mb-1 shadow-none"
                                required>
                                <option disabled {{ old('id_divisi') ? '' : 'selected' }}>Pilih Divisi</option>
                                @foreach ($divisis as $divisi)
                                    <option value="{{ $divisi->id_divisi }}"
                                        {{ old('id_divisi') == $divisi->id_divisi ? 'selected' : '' }}>
                                        {{ $divisi->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_divisi')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>






                    <div class="form-group mb-1 row">
                        <label for="id_strata_create" class="col-sm-3 col-form-label">Strata</label>
                        <div class="col-sm-9">
                            <select name="id_strata" id="id_strata_create" class="form-control mb-1 shadow-none"
                                required>
                                <option disabled {{ old('id_strata') ? '' : 'selected' }}>Pilih Strata</option>
                                @foreach ($stratas as $strata)
                                    <option value="{{ $strata->id_strata }}"
                                        {{ old('id_strata') == $strata->id_strata ? 'selected' : '' }}>
                                        {{ $strata->nama_strata }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_strata')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="email_karyawan_create" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email"
                                class="form-control @error('email_karyawan') is-invalid @enderror mb-1"
                                id="email_karyawan_create" aria-describedby="email_karyawan" name="email_karyawan"
                                value="{{ old('email_karyawan') }}" required>
                            @error('email_karyawan')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="password_create" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('password') is-invalid @enderror mb-1"
                                id="password_create" aria-describedby="password" name="password"
                                value="{{ old('password') }}" placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="gaji_create" class="col-sm-3 col-form-label">Gaji (Rp.)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('gaji') is-invalid @enderror mb-1"
                                id="gaji_create" aria-describedby="gaji" name="gaji" value="{{ old('gaji') }}"
                                placeholder="Masukkan gaji" required>
                            @error('gaji')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <script>
                        var gajiInput = document.getElementById('gaji_create');
                        gajiInput.addEventListener('keyup', function(e) {
                            gajiInput.value = formatRupiah(this.value);
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


                    <div class="form-group mb-1 row">
                        <label for="id_role_create" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select name="id_role" id="id_role_create" class="form-control mb-1 shadow-none"
                                required>
                                <option disabled {{ old('id_role') ? '' : 'selected' }}>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id_role }}"
                                        {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
                                        {{ $role->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_role')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="modal-body" style="color: black;">
                        <div class="form-group mb-1 row">
                            <label for="status_active_create" class="col-sm-3 col-form-label">Status Active</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        id="defaultCheck1" name="status_active" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
                </div>


            </div>
        </div>
    </form>
</div>
