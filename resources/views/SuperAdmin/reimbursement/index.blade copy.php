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
                @include('template.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-2 text-gray-800">Table Data Master Role</h1>
                    <p class="mb-4">Data master role berisikan data role</p> --}}

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">Pengajuan Reimbursement</h6>
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
                            <form action="{{ route('reimbursement.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Reimbursement Details -->
                                <div class="form-group">
                                    <label for="jenis_reimbursement">Jenis Reimbursement</label>
                                    <select class="form-control" onchange="showhidesupplier(this); showhideproyek(this)"
                                        name="id_jenis_reimbursement" required>
                                        <option value="">-- Pilih Jenis Reimbursement --</option>
                                        @foreach ($jenisReimbursement as $jenis)
                                        <option value="{{ $jenis->id_jenis_reimbursement }}"
                                            {{ old('id_jenis_reimbursement') == $jenis->id_jenis_reimbursement ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis_reimbursement }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" id="proyek" style="display:none">
                                    <label for="id_proyek">Proyek (Reimbursement Perjalanan Bisnis)</label>
                                    <select class="form-control" name="id_proyek">
                                        <option value="">-- Pilih Proyek --</option>
                                        @foreach ($proyek as $proy)
                                        <option value="{{ $proy->id_proyek }}"
                                            {{ old('id_proyek') == $proy->id_proyek ? 'selected' : '' }}>
                                            {{ $proy->nama_proyek }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" id="supplier" style="display:none">
                                    <label for="id_supplier">Supplier (Reimbursement Penunjang Kantor)</label>
                                    <select class="form-control" name="id_supplier">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($supplier as $supp)
                                        <option value="{{ $supp->id_supplier }}"
                                            {{ old('id_supplier') == $supp->id_supplier ? 'selected' : '' }}>
                                            {{ $supp->nama_supplier }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_user">Nama Karyawan</label>
                                    <div class="input-group">
                                        <select name="id_user" id="nama_karyawan" class="form-control"
                                            onchange="showSelectedName()" data-live-search="true">
                                            <option value="">-- Nama Karyawan --</option>
                                            @foreach ($user as $u)
                                            <option value="{{ $u->id_user }}">{{ $u->nama_karyawan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_user')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#nama_karyawan').select2({
                                            placeholder: 'Cari Nama Karyawan...',
                                            allowClear: true
                                        });
                                    });

                                    function showSelectedName() {
                                        var selectedName = $("#nama_karyawan option:selected").text();
                                        console.log(selectedName);
                                        // Lakukan sesuatu dengan nama yang terpilih
                                    }
                                    </script>
                                </div>


                                {{-- <div class="form-group">
                                    <label for="id_user">Nama Karyawan</label>
                                    <div class="input-group">
                                        <select name="id_user" id="id_user" class="form-control"
                                            onchange="showSelectedName()" data-live-search="true">
                                            <option value="">-- Nama Karyawan --</option>
                                            @foreach ($user as $u)
                                                <option value="{{ $u->id_user }}">{{ $u->nama_karyawan }}</option>
                                @endforeach
                                </select>
                                <div class="input-group-append">
                                    <input type="text" id="searchInput" onkeyup="searchNames()" class="form-control"
                                        placeholder="Cari nama karyawan..." value="{{ old('searchInput') }}">
                                </div>
                        </div>
                        <div id="searchResults"></div>
                        @error('id_user')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <script>
                    function searchNames() {
                        // Mendapatkan input pencarian
                        var input = document.getElementById("searchInput");
                        var filter = input.value.toUpperCase();

                        // Mendapatkan opsi pada elemen <select>
                        var select = document.getElementById("id_user");
                        var options = select.getElementsByTagName("option");

                        // Iterasi melalui opsi dan menyembunyikan yang tidak cocok dengan pencarian
                        for (var i = 0; i < options.length; i++) {
                            var option = options[i];
                            var txtValue = option.textContent || option.innerText;

                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                option.style.display = "";
                            } else {
                                option.style.display = "none";
                            }
                        }
                    }

                    function showSelectedName() {
                        // Mendapatkan opsi yang dipilih
                        var select = document.getElementById("id_user");
                        var selectedOption = select.options[select.selectedIndex];

                        // Menampilkan nama karyawan yang dipilih
                        var selectedName = selectedOption.textContent || selectedOption.innerText;
                        console.log("Nama Karyawan Terpilih:", selectedName);
                    }
                    </script>





                    <div class="form-group">
                        <label for="tanggal_bayar">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control"
                            value="{{ old('tanggal_bayar') }}" max="{{ date('Y-m-d') }}">
                        @error('tanggal_bayar')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Deskripsi</label>
                        <textarea name="keterangan" id="keterangan" rows="5"
                            class="form-control">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="text" name="total" id="total_create" class="form-control"
                            value="{{ old('total') }}">
                        @error('total')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                    var totalInput = document.getElementById('total_create');
                    totalInput.addEventListener('keyup', function(e) {
                        formatRupiah(this);
                    });

                    function formatRupiah(input) {
                        var angka = input.value;
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

                        input.value = rupiah;
                    }
                    </script>




                    <div id="lampiran-container"></div>

                    <button type="button" onclick="tambahLampiran()" class="btn btn-info">Tambah
                        Lampiran</button>

                    <script>
                    let counter = 1;

                    function tambahLampiran() {
                        const lampiranContainer = document.getElementById("lampiran-container");

                        const lampiranDiv = document.createElement("div");
                        lampiranDiv.id = `lampiran-div-${counter}`;
                        lampiranDiv.innerHTML = `
                                      <h5 class="m-2 font-weight-bold text-gray-900 mb-3">Lampiran Reimbursement ${counter}</h5>
                                      <button type="button" class="btn btn-danger btn-circle btn-sm flex-end" id="hapus-lampiran-${counter}" style="display: none;" onclick="hapusLampiran(${counter})">
                                        <i class="fas fa-trash"></i>
                                      </button>
                                
                                      <!-- Isi form lampiran -->
                                      <div class="form-group mb-1 row">
                                        <label for="nomor_kwitansi_${counter}" class="col-sm-2 col-form-label">Nomor Kwitansi</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control mb-1" name="lampiran[${counter}][nomor_kwitansi]" id="nomor_kwitansi_${counter}" required>
                                        </div>
                                      </div>
                                
                                      <div class="form-group mb-1 row">
                                        <label for="tanggal_kwitansi_${counter}" class="col-sm-2 col-form-label">Tanggal Kwitansi</label>
                                        <div class="col-sm-10">
                                          <input type="date" class="form-control mb-1" name="lampiran[${counter}][tanggal_kwitansi]" id="tanggal_kwitansi_${counter}" max="${getCurrentDate()}" required>
                                        </div>
                                      </div>
                                
                                      <div class="form-group mb-1 row">
                                        <label for="judul_kwitansi_${counter}" class="col-sm-2 col-form-label">Judul Lampiran</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control mb-1" name="lampiran[${counter}][judul_kwitansi]" id="judul_kwitansi_${counter}" required>
                                        </div>
                                      </div>
                                
                                      <div class="form-group mb-1 row">
                                        <label for="nama_kwitansi_${counter}" class="col-sm-2 col-form-label">Nama Kwitansi</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control mb-1" name="lampiran[${counter}][nama_kwitansi]" id="nama_kwitansi_${counter}" required>
                                        </div>
                                      </div>
                                
                                      <div class="form-group mb-1 row">
                                        <label for="lampiran_${counter}_file" class="col-sm-2 col-form-label">File (.png, .jpeg, .pdf)</label>
                                        <div class="col-sm-10">
                                          <input type="file" id="lampiran_${counter}_file" name="lampiran[${counter}][file]" class="form-control mb-1" accept=".png, .jpeg, .jpg, .pdf" required>
                                        </div>
                                      </div>
                                
                                      <div class="form-group mb-1 row">
                                        <label for="keterangan_lampiran_${counter}" class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                          <textarea type="text" class="form-control mb-1" name="lampiran[${counter}][keterangan]" id="keterangan_lampiran_${counter}"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group mb-1 row">
                                            <label for="total_kwitansi_${counter}" class="col-sm-2 col-form-label">Total Kwitansi</label>
                                            <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1" name="lampiran[${counter}][total_kwitansi]" id="total_kwitansi_${counter}" onkeyup="formatRupiah(this)" required>
                                            </div>
                                        </div>
                                    `;

                        lampiranContainer.appendChild(lampiranDiv);

                        const tombolHapus = document.getElementById(`hapus-lampiran-${counter}`);
                        tombolHapus.style.display = "block";
                        tombolHapus.disabled = false;

                        counter++;

                        cekStatusSubmit();
                        cekStatusValidasi();
                    }

                    function hapusLampiran(index) {
                        const lampiranDiv = document.getElementById(`lampiran-div-${index}`);
                        lampiranDiv.remove();

                        cekStatusSubmit();
                        cekStatusValidasi();
                    }

                    function cekStatusSubmit() {
                        const jumlahLampiran = document.getElementById("lampiran-container").childElementCount;
                        const submitButton = document.getElementById("submit-button");

                        if (jumlahLampiran >= 1) {
                            submitButton.disabled = false;
                        } else {
                            submitButton.disabled = true;
                        }
                    }

                    function cekStatusValidasi() {
                        const jumlahLampiran = document.getElementById("lampiran-container").childElementCount;
                        const lampiranValidasi = document.getElementById("lampiran-validasi");

                        if (jumlahLampiran >= 1) {
                            lampiranValidasi.style.display = "none";
                        } else {
                            lampiranValidasi.style.display = "block";
                        }
                    }

                    function formatRupiah(input) {
                        var angka = input.value;
                        var number_string = angka.replace(/[^,\d]/g, "").toString();
                        var split = number_string.split(",");
                        var sisa = split[0].length % 3;
                        var rupiah = split[0].substr(0, sisa);
                        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        if (ribuan) {
                            separator = sisa ? "." : "";
                            rupiah += separator + ribuan.join(".");
                        }

                        rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

                        input.value = rupiah;
                    }

                    function getCurrentDate() {
                        const currentDate = new Date();
                        const year = currentDate.getFullYear();
                        const month = String(currentDate.getMonth() + 1).padStart(2, "0");
                        const day = String(currentDate.getDate()).padStart(2, "0");
                        return `${year}-${month}-${day}`;
                    }
                    </script>


                    <!-- Submit Button -->
                    <br>


                    <span id="lampiran-validasi" class="text-danger" style="display: block">*( Wajib mengisi
                        1 form data lampiran ! )</span>

                    <br>

                    <div>
                        <button id="submit-button" type="submit" class="btn btn-primary" disabled>Submit</button>
                    </div>


                    </form>

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