<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>

    <title>Update Reimbursement Medical</title>

    @include('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('template.left-sidebar-Karyawan')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar-Karyawan')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900"></h6>
                        </div> --}}

                        <div class="card-header py-3">
                            <h6 class="font-weight-bold text-gray-900">
                                <a href="/karyawan/medical" class="arrow-link">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a>
                                Update Pengajuan Reimbursement Medical
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
                            <form action="{{ route('kmedical.update', $reimbursement->id_reimbursement) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Reimbursement Details -->


                                <div class="form-group">
                                    <label for="jenis_reimbursement">Jenis Reimbursement</label>
                                    @foreach ($jenisReimbursement as $jenis)
                                        <div class="col-sm-12">
                                            <label class="form-control mb-2 row">
                                                <input type="radio" name="id_jenis_reimbursement"
                                                    value="{{ $jenis->id_jenis_reimbursement }}"
                                                    onclick="showhidesupplierproyekUpdate(this);" required
                                                    {{ $jenis->id_jenis_reimbursement == $reimbursement->id_jenis_reimbursement ? 'checked' : '' }}>
                                                {{ $jenis->nama_jenis_reimbursement }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group" id="proyek" style="display: none">
                                    <label for="proyek">Proyek (Reimbursement Perjalanan Bisnis)</label>
                                    <select class="form-control" name="id_proyek">
                                        <option value="">-- Pilih Proyek --</option>
                                        @foreach ($proyek as $proy)
                                            <option value="{{ $proy->id_proyek }}"
                                                {{ $proy->id_proyek == $lampirans[0]->id_proyek ? 'selected' : '' }}>
                                                {{ $proy->nama_proyek }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" id="supplier" style="display: none">
                                    <label for="supplier">Supplier (Reimbursement Penunjang Kantor)</label>
                                    <select class="form-control" name="id_supplier">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($supplier as $supp)
                                            <option value="{{ $supp->id_supplier }}"
                                                {{ $supp->id_supplier == $lampirans[0]->id_supplier ? 'selected' : '' }}>
                                                {{ $supp->nama_supplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <script>
                                    // Function to show/hide proyek and supplier based on selected jenis reimbursement
                                    function showhidesupplierproyekUpdate(radio) {
                                        var proyekDiv = document.getElementById("proyek");
                                        var supplierDiv = document.getElementById("supplier");

                                        if (radio.value === "2") {
                                            proyekDiv.style.display = "block";
                                            supplierDiv.style.display = "none";
                                        } else if (radio.value === "4") {
                                            proyekDiv.style.display = "none";
                                            supplierDiv.style.display = "block";
                                        } else {
                                            proyekDiv.style.display = "none";
                                            supplierDiv.style.display = "none";
                                        }
                                    }

                                    // Trigger the function initially when the page loads
                                    showhidesupplierproyekUpdate(document.querySelector("[name='id_jenis_reimbursement']:checked"));
                                </script>



                                <div class="form-group" style="display: none;">
                                    <label for="id_user">Nama Karyawan</label>
                                    <select name="id_user" id="id_user" class="form-control">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach ($user as $u)
                                            <option value="{{ $u->id_user }}"
                                                {{ $u->id_user == $reimbursement->id_user ? 'selected' : '' }}>
                                                {{ $u->nama_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_user')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="tanggal_bayar" style="color: black; width: 25%;">Tanggal Bayar</label>
                                    <input type="date" name="tanggal_bayar" max="{{ date('Y-m-d') }}"
                                        id="tanggal_bayar" class="form-control"
                                        value="{{ old('tanggal_bayar', $reimbursement->tanggal_bayar ? \Carbon\Carbon::parse($reimbursement->tanggal_bayar)->format('Y-m-d') : '') }}">
                                    @error('tanggal_bayar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" id="total_update" class="form-control"
                                        value="{{ old('total', $reimbursement->total) }}">
                                    @error('total')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="form-group">
                                    <label for="keterangan" style="color: black; width: 25%;">Deskripsi</label>
                                    <textarea name="keterangan_reim" id="keterangan" rows="5" class="form-control">{{ old('keterangan', $reimbursement->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="total" style="color: black; width: 25%;">Total</label>
                                    <input type="text" name="total" id="total_create" class="form-control"
                                        value="{{ number_format(old('total', $reimbursement->total), 0, ',', '.') }}"
                                        disabled>
                                    <input type="hidden" name="total_hidden" id="total_hidden"
                                        value="{{ number_format(old('total', $reimbursement->total), 0, ',', '.') }}">
                                    <span class="text-muted"> *Total akan terisi otomatis apabila total kwitansi di
                                        lampiran terisi</span>
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


                                {{-- LAMPIRAN --}}

                                @foreach ($newLampirans as $index => $lampiran)
                                    <div class="card-header py-3 mt-3 mb-2">
                                        <h6 class="m-0 font-weight-bold text-gray-900">
                                            Lampiran Reimbursement {{ $index + 1 }}
                                        </h6>
                                        @if (isset($lampiran['id_lampiran']))
                                            @if (count($newLampirans) > 1)
                                                <button type="button" class="btn btn-danger btn-circle btn-sm flex-end"
                                                    data-toggle="modal" title="Delete Reimbursement"
                                                    data-target="#deleteModalLampiran{{ $index + 1 }}"
                                                    onclick="deleteLampiran('{{ $lampiran['id_lampiran'] }}', '{{ $index }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>


                                    <script>
                                        // Ajax request untuk menghapus lampiran
                                        function deleteLampiran(lampiranId, ajaxIndex) {
                                            // Buat objek XMLHttpRequest
                                            var xhr = new XMLHttpRequest();

                                            // Konfigurasi permintaan AJAX
                                            xhr.open('DELETE', '/hapus-lampiran-kmedical', true);
                                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                                            // Menangani respons permintaan AJAX
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    // Tangani respons sukses
                                                    console.log('Lampiran berhasil dihapus.');

                                                    // Ganti id_lampiran di array
                                                    if (ajaxIndex === 1) {
                                                        for (var i = 2; i < lampiran.length; i++) {
                                                            lampiran[i]['id_lampiran'] = lampiran[i - 1]['id_lampiran'];
                                                        }
                                                    }

                                                    // Refresh halaman setelah menghapus lampiran
                                                    location.reload();
                                                } else {
                                                    // Tangani respons gagal
                                                    console.log('Gagal menghapus lampiran.');
                                                }
                                            };

                                            // Mengirim permintaan AJAX dengan data yang diperlukan
                                            var data = '_method=DELETE&lampiranId=' + encodeURIComponent(lampiranId);
                                            xhr.send(data);
                                        }
                                    </script>


                                    <div class="form-group mb-1 row">
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control mb-1"
                                                aria-describedby="id_lampiran"
                                                name="lampiran[{{ $index }}][id_lampiran]"
                                                value="{{ $lampiran['id_lampiran'] ?? '' }}" hidden>
                                        </div>
                                    </div>


                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label" style="color: black; width: 25%;">Nomor
                                            Lampiran</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control mb-1"
                                                aria-describedby="nomor_kwitansi"
                                                name="lampiran[{{ $index }}][nomor_kwitansi]"
                                                value="{{ $lampiran['nomor_kwitansi'] }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label"
                                            style="color: black; width: 25%;">Tanggal Lampiran</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control mb-1"
                                                max="{{ date('Y-m-d') }}" aria-describedby="tanggal_kwitansi"
                                                name="lampiran[{{ $index }}][tanggal_kwitansi]"
                                                value="{{ $lampiran['tanggal_kwitansi'] }}" required>
                                        </div>
                                        @error('tanggal_kwitansi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label" style="color: black; width: 25%;">Judul
                                            Lampiran</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1"
                                                aria-describedby="judul_kwitansi"
                                                name="lampiran[{{ $index }}][judul_kwitansi]"
                                                value="{{ $lampiran['judul_kwitansi'] }}" required>
                                        </div>
                                    </div>
                                    <div class=" form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label" style="color: black; width: 25%;">Nama
                                            Lampiran</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1"
                                                aria-describedby="nama_kwitansi"
                                                name="lampiran[{{ $index }}][nama_kwitansi]"
                                                value="{{ $lampiran['nama_kwitansi'] }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label"
                                            style="color: black; width: 25%;">File</label>
                                        <div>
                                            <div class="col-sm-10">
                                                <input type="file" name="lampiran[{{ $index }}][file]"
                                                    class="form-control mb-1" aria-describedby="file"
                                                    accept=".png, .jpeg, .jpg, .pdf" value="{{ $lampiran['file'] }}">
                                                @php
                                                    $FileName = 'Lampiran';
                                                    $extension = pathinfo($lampiran['file'], PATHINFO_EXTENSION);
                                                    $fileName = Auth::user()->nama_karyawan . '_' . date('dmY') . '_' . $FileName . '.' . $extension;
                                                @endphp

                                                @if (in_array($extension, ['png', 'jpeg', 'jpg']))
                                                    @if (isset($lampiran['fileUrl']))
                                                        <img src="{{ $lampiran['fileUrl'] }}" alt="File Lampiran"
                                                            width="200" class="mb-2">
                                                        <a href="{{ asset('LampiranBaru/' . $lampiran['file']) }}"
                                                            target="_blank" class="mb-2">Lihat Detail</a>
                                                    @endif

                                                    <div>
                                                        @if (isset($lampiran['fileUrl']))
                                                            <a href="{{ $lampiran['fileUrl'] }}"
                                                                download="{{ $fileName }}"
                                                                class="btn btn-primary btn-icon-split btn-sm">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-download"></i>
                                                                </span>
                                                                <span class="text">Unduh
                                                                    Gambar</span></a>
                                                        @endif
                                                    </div>
                                                @elseif ($extension === 'pdf')
                                                    @if (isset($lampiran['fileUrl']))
                                                        <iframe src="{{ $lampiran['fileUrl'] }}" width="100%"
                                                            height="300px"></iframe>
                                                        <a href="{{ asset('LampiranPDFBaru/' . $lampiran['file']) }}"
                                                            target="_blank" class="mb-2">Lihat Detail
                                                            PDF</a>
                                                    @endif

                                                    <div>
                                                        @if (isset($lampiran['fileUrl']))
                                                            <a href="{{ $lampiran['fileUrl'] }}"
                                                                download="{{ $fileName }}"
                                                                class="btn btn-primary btn-icon-split btn-sm">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-download"></i>
                                                                </span>
                                                                <span class="text">Unduh
                                                                    PDF</span></a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label"
                                            style="color: black; width: 25%;">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control mb-1" aria-describedby="keterangan" name="lampiran[{{ $index }}][keterangan]">{{ $lampiran['keterangan'] }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label" style="color: black; width: 25%;">Total
                                            Kwitansi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1"
                                                aria-describedby="total_kwitansi"
                                                name="lampiran[{{ $index }}][total_kwitansi]"
                                                value="{{ number_format($lampiran['total_kwitansi'], 0, ',', '.') }}"
                                                required
                                                oninput="formatRupiah(this); updateTotal(); toggleTotalInput(this);">
                                        </div>
                                    </div>
                                @endforeach


                                {{-- BAGIANNN TAMBAH LAMPIRAN    --}}


                                <div id="lampiran-container"></div>

                                <button type="button" onclick="tambahLampiran()" class="btn btn-info">Tambah
                                    Lampiran</button>

                                <script>
                                    let counter = {{ count($newLampirans) + 1 }};

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
                                        <label for="nomor_kwitansi_${counter}" class="col-sm-2 col-form-label">Nomor Lampiran</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control mb-1" name="lampiran[${counter}][nomor_kwitansi]" id="nomor_kwitansi_${counter}" required>
                                        </div>
                                      </div>
                                
                                      <div class="form-group mb-1 row">
                                        <label for="tanggal_kwitansi_${counter}" class="col-sm-2 col-form-label">Tanggal Lampiran</label>
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
                                        <label for="nama_kwitansi_${counter}" class="col-sm-2 col-form-label">Nama Lampiran</label>
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
                                                <input type="text" class="form-control mb-1" name="lampiran[${counter}][total_kwitansi]" id="total_kwitansi_${counter}" onkeyup="formatRupiah(this); updateTotalCreate()" required>
                                                <span class="text-muted" id="total_kwitansi_text_${counter}"> *Apabila lampiran berupa kwitansi berikan nilai pada "total kwitansi" jika tidak isi "0" </span>
                                            </div>
                                        </div>
                                    `;

                                        lampiranContainer.appendChild(lampiranDiv);

                                        const tombolHapus = document.getElementById(`hapus-lampiran-${counter}`);
                                        tombolHapus.style.display = "block";
                                        tombolHapus.disabled = false;

                                        counter++;


                                        cekStatusValidasi();
                                        cekStatusTambahLampiran();
                                    }


                                    function getCurrentDate() {
                                        const currentDate = new Date();
                                        const year = currentDate.getFullYear();
                                        const month = String(currentDate.getMonth() + 1).padStart(2, "0");
                                        const day = String(currentDate.getDate()).padStart(2, "0");
                                        return `${year}-${month}-${day}`;
                                    }

                                    function cekStatusValidasi() {
                                        const jumlahLampiran = document.getElementById("lampiran-container").childElementCount;
                                        const lampiranValidasi = document.getElementById("lampiran-validasi");

                                        if (jumlahLampiran >= 1) {
                                            lampiranValidasi.style.display = "block";
                                        } else {
                                            lampiranValidasi.style.display = "none";
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

                                        updateTotalCreate();
                                    }

                                    function hapusLampiran(index) {
                                        const lampiranDiv = document.getElementById(`lampiran-div-${index}`);
                                        lampiranDiv.remove();

                                        updateTotalCreate();
                                        cekStatusValidasi();
                                    }

                                    // Move the updateTotalCreate function outside the deleteLampiran function
                                    function updateTotalCreate() {
                                        const totalInput = document.getElementById("total_create");
                                        const totalKwitansiInputs = document.querySelectorAll(
                                            "input[name^='lampiran'][name$='[total_kwitansi]']"
                                        );

                                        let total = 0;
                                        totalKwitansiInputs.forEach((input) => {
                                            const inputValue = input.value.replace(/[^0-9]/g, "");
                                            const inputValueNumber = Number(inputValue);
                                            total += inputValueNumber;
                                        });

                                        const formattedTotal = formatNumber(total);
                                        totalInput.value = formattedTotal;
                                        document.getElementById('total_hidden').value = total;
                                    }

                                    // Call updateTotalCreate function after the page has finished loading
                                    window.onload = function() {
                                        updateTotalCreate();
                                    };

                                    function formatNumber(number) {
                                        return number.toLocaleString("id-ID");
                                    }
                                </script>

                                <!-- Submit Button -->
                                <br>


                                <span id="lampiran-validasi" class="text-info" style="display: none">*( Jika
                                    melakukan tambah lampiran wajib mengisi semua field , kecuali keterangan
                                    optional)</span>

                                <br>
                                <!-- Submit Button -->
                                <div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
