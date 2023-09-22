<!-- Modal -->
<div class="modal fade" id="editModalKaryawan{{ $karyawan->id_user }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $karyawan->id_user }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{ $karyawan->id_user }}" style="color: white;">Edit
                    Karyawan - {{ $karyawan->nama_karyawan }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('karyawan.update', $karyawan->id_user) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_user" id="id_user">

                    <div class="form-group mb-3 row">
                        <label for="nomor_identitas_karyawan" class="col-sm-3 col-form-label">No Identitas</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="nomor_identitas_karyawan"
                                name="nomor_identitas_karyawan" value="{{ $karyawan->nomor_identitas_karyawan }}">
                            @error('nomor_identitas_karyawan')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="nama_karyawan" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan"
                                value="{{ $karyawan->nama_karyawan }}">
                            @error('nama')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label for="id_divisi" class="col-sm-3 col-form-label">Divisi</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="id_divisi" name="id_divisi">
                                @foreach ($divisis as $divisi)
                                    <option value="{{ $divisi->id_divisi }}"
                                        @if ($karyawan->id_divisi == $divisi->id_divisi) selected @endif>{{ $divisi->nama_divisi }}
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
                    <div class="form-group mb-3 row">
                        <label for="strata" class="col-sm-3 col-form-label">Strata</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="strata" name="id_strata">
                                @foreach ($stratas as $strata)
                                    <option value="{{ $strata->id_strata }}"
                                        @if ($karyawan->id_strata == $strata->id_strata) selected @endif>{{ $strata->nama_strata }}
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
                    <div class="form-group mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email_karyawan"
                                value="{{ $karyawan->email_karyawan }}">
                            @error('email_karyawan')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group mb-3 row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" value="********">
                            <input type="hidden" id="actual_password" name="actual_password"
                                value="{{ $karyawan->password }}">
                            @error('password')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <script>
                        var passwordInput = document.getElementById('password');
                        var actualPasswordInput = document.getElementById('actual_password');

                        passwordInput.addEventListener('focus', function() {
                            if (passwordInput.value === '********') {
                                passwordInput.value = '';
                            }
                        });

                        passwordInput.addEventListener('blur', function() {
                            if (passwordInput.value === '') {
                                passwordInput.value = '********';
                            }
                        });

                        actualPasswordInput.addEventListener('change', function() {
                            passwordInput.value = '********';
                        });
                    </script>


                    <div class="form-group mb-3 row">
                        <label for="gaji_update" class="col-sm-3 col-form-label">Gaji (Rp.)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('gaji') is-invalid @enderror"
                                id="gaji_update" name="gaji" value="{{ $karyawan->gaji }}"
                                placeholder="Masukkan gaji" required>
                            @error('gaji')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <script>
                        var gajiInputs = document.querySelectorAll('#gaji_update');
                        gajiInputs.forEach(function(gajiInput) {
                            gajiInput.addEventListener('keyup', function(e) {
                                gajiInput.value = formatRupiah(this.value);
                            });
                        });

                        function formatRupiah(angka) {
                            var number_string = angka.replace(/[^,\d]/g, '').toString();
                            var split = number_string.split(',');
                            var sisa = split[0].length % 3;
                            var rupiah = split[0].substr(0, sisa);
                            var ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }

                            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

                            return rupiah;
                        }
                    </script>

                    <div class="form-group mb-3 row">
                        <label for="role" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="role" name="id_role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id_role }}"
                                        @if ($karyawan->id_role == $role->id_role) selected @endif>{{ $role->nama_role }}
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
                            <label for="status_active_update" class="col-sm-4 col-form-label">Status Active</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        id="defaultCheck1" name="status_active"
                                        {{ $karyawan->status_active == 1 ? 'checked' : '' }}>
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
