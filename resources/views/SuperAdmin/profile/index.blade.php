<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>

    <title>Formulir Reimbursement</title>

    @include('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('template.left-sidebar-SuperAdmin')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar-SuperAdmin')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-2 text-gray-800">Table Data Master Role</h1>
                    <p class="mb-4">Data master role berisikan data role</p> --}}

                    <!-- DataTales Example -->
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-gray-900">
                                        Foto Pengguna
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <!-- Display Profile Picture -->
                                    <style>
                                        #preview-image {
                                            width: 200px;
                                            height: 200px;
                                            border-radius: 50%;
                                            object-fit: cover;
                                        }
                                    </style>

                                    <div class="text-center">
                                        @if ($karyawan->foto_profile)
                                            <img src="{{ asset('FotoProfile/' . $karyawan->foto_profile) }}"
                                                alt="Foto Profil" id="preview-image" class="img-fluid rounded-circle">
                                        @else
                                            <img src="{{ asset('template/img/undraw_profile.svg') }}" alt="Foto Profil"
                                                class="img-fluid">
                                        @endif
                                    </div>

                                    <!-- Upload Profile Picture Form -->
                                    <form
                                        action="{{ route('superadmin.profile.updateFotoProfile', ['id_user' => $karyawan->id_user]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id_user" id="id_user">

                                        <div class="form-group mb-3">
                                            <label for="foto_profil" class="col-form-label">
                                                <small>* Upload Foto Profil (PNG , JPEG , JPG)</small>
                                            </label>
                                            <input type="file" class="form-control-file" id="foto_profil"
                                                name="foto_profil" accept=".png, .jpeg, .jpg,"
                                                onchange="previewImage(event)">
                                            @error('foto_profil')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        {{-- <script>
                                            function previewImage(event) {
                                                var input = event.target;
                                                var reader = new FileReader();
                                                reader.onload = function() {
                                                    var imgElement = document.getElementById("preview-image");
                                                    imgElement.src = reader.result;
                                                };
                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        </script> --}}

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-gray-900">
                                        {{-- <a href="/superadmin/dashboard" class="arrow-link">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a> --}}
                                        Kelola Pengguna
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <!-- Add Reimbursement Form -->
                                    <form
                                        action="{{ route('superadmin.profile.updateKelolaPengguna', ['id_user' => $karyawan->id_user]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id_user" id="id_user">

                                        <div class="form-group mb-3">
                                            <label for="nomor_identitas_karyawan" class="col-form-label"
                                                style="color: black; width: 100%;">No
                                                Identitas</label>
                                            {{-- <div class="col-sm-9"> --}}
                                            <input type="number" class="form-control" id="nomor_identitas_karyawan"
                                                name="nomor_identitas_karyawan"
                                                value="{{ $karyawan->nomor_identitas_karyawan }}">
                                            @error('nomor_identitas_karyawan')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            {{-- </div> --}}
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="nama_karyawan" class="col-form-label"
                                                style="color: black; width: 100%;">Nama</label>

                                            <input type="text" class="form-control" id="nama_karyawan"
                                                name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}">
                                            @error('nama')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="telepon" class="col-form-label"
                                                style="color: black; width: 100%;">Telepon</label>
                                            <input type="tel" class="form-control" id="telepon" name="telepon"
                                                value="{{ $karyawan->telepon }}">
                                            @error('telepon')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="tanggal_masuk" class="col-form-label"
                                                style="color: black; width: 100%;">Tanggal Masuk</label>
                                            <input type="date" class="form-control" id="tanggal_masuk"
                                                name="tanggal_masuk" value="{{ $karyawan->tanggal_masuk }}">
                                            @error('tanggal_masuk')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>



                                        {{-- <div class="form-group mb-3">
                                            <label for="id_divisi" class="col-form-label"
                                                style="color: black; width: 100%;">Divisi</label>
                                            <select class="form-control" id="id_divisi" name="id_divisi">
                                                @foreach ($divisis as $divisi)
                                                    <option value="{{ $divisi->id_divisi }}"
                                                        @if ($karyawan->id_divisi == $divisi->id_divisi) selected @endif>
                                                        {{ $divisi->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_divisi')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        <div class="form-group mb-3">
                                            <label for="strata" class="col-form-label"
                                                style="color: black; width: 100%;">Strata</label>
                                            {{-- <div class="col-sm-9"> --}}
                                            <select class="form-control" id="strata" name="id_strata">
                                                @foreach ($stratas as $strata)
                                                    <option value="{{ $strata->id_strata }}"
                                                        @if ($karyawan->id_strata == $strata->id_strata) selected @endif>
                                                        {{ $strata->nama_strata }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_strata')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            {{-- </div> --}}
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="gaji_update" class="col-form-label"
                                                style="color: black; width: 100%;">Gaji (Rp.)</label>
                                            {{-- <div class="col-sm-9"> --}}
                                            <input type="text"
                                                class="form-control @error('gaji') is-invalid @enderror"
                                                id="gaji_update" name="gaji"
                                                value="{{ number_format($karyawan->gaji, 0, ',', '.') }}"
                                                placeholder="Masukkan gaji" required>
                                            @error('gaji')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            {{-- </div> --}}
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

                                        <div class="form-group mb-3">
                                            <label for="alamat_lengkap" class="col-form-label"
                                                style="color: black; width: 100%;">Alamat Lengkap</label>
                                            <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3">{{ $karyawan->alamat_lengkap }}</textarea>
                                            @error('alamat_lengkap')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>





                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-gray-900">
                                        {{-- <a href="/superadmin/dashboard" class="arrow-link">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a> --}}
                                        Kelola Akun
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <!-- Add Reimbursement Form -->
                                    <form
                                        action="{{ route('superadmin.profile.updateKelolaAkun', ['id_user' => $karyawan->id_user]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id_user" id="id_user">

                                        <div class="form-group mb-3 ">
                                            <label for="email" class="col-form-label"
                                                style="color: black; width: 100%;">Email</label>
                                            {{-- <div class="col-sm-9"> --}}
                                            <input type="email" class="form-control" id="email"
                                                name="email_karyawan" value="{{ $karyawan->email_karyawan }}">
                                            @error('email_karyawan')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            {{-- </div> --}}
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password" class="col-form-label"
                                                style="color: black; width: 100%;">Password</label>
                                            {{-- <div class="col-sm-9"> --}}
                                            <input type="password" class="form-control" id="password"
                                                name="password" value="********">
                                            <input type="hidden" id="actual_password" name="actual_password"
                                                value="{{ $karyawan->password }}">
                                            @error('password')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            {{-- </div> --}}
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



                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('template.footer')

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('template.script')
    @include('sweetalert::alert')
</body>

</html>
