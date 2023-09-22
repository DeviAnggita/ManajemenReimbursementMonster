<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>

    <title>Update Reimbursement Medical </title>

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
                            <h6 class="m-0 font-weight-bold text-gray-900">Update Reimbursement Medical</h6>
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
                            <form action="{{ route('medical.update', $reimbursement->id_reimbursement) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Reimbursement Details -->

                                {{-- <div class="form-group" id="supplier" style="display:none">
                                    <label for="id_supplier">Supplier (Reimbursement Penunjang Kantor)</label>
                                    <select class="form-control" name="id_supplier">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($supplier as $supp)
                                        <option value="{{ $supp->id_supplier }}">
                                            {{ $supp->nama_supplier }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}



                                <div class="form-group">
                                    <label for="jenis_reimbursement">Jenis Reimbursement</label>
                                    <select class="form-control" onchange="showhidesupplier(this); showhideproyek(this)"
                                        name="id_jenis_reimbursement" required>
                                        <option value="">-- Pilih Jenis Reimbursement --</option>
                                        @foreach ($jenisReimbursement as $jenis)
                                            <option value="{{ $jenis->id_jenis_reimbursement }}"
                                                {{ $jenis->id_jenis_reimbursement == $reimbursement->id_jenis_reimbursement ? 'selected' : '' }}>
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
                                                {{ $proy->id_proyek == $lampiran->id_proyek ? 'selected' : '' }}>
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
                                                {{ $supp->id_supplier == $lampiran->id_supplier ? 'selected' : '' }}>
                                                {{ $supp->nama_supplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
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
                                    <label for="tanggal_bayar">Tanggal Bayar</label>
                                    <input type="date" name="tanggal_bayar" max="{{ date('Y-m-d') }}"
                                        id="tanggal_bayar" class="form-control"
                                        value="{{ old('tanggal_bayar', $reimbursement->tanggal_bayar ? \Carbon\Carbon::parse($reimbursement->tanggal_bayar)->format('Y-m-d') : '') }}">
                                    @error('tanggal_bayar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_reimbursement">Tanggal Reimbursement</label>
                                    <input type="date" name="tanggal_reimbursement" max="{{ date('Y-m-d') }}"
                                        id="tanggal_reimbursement" class="form-control"
                                        value="{{ old('tanggal_reimbursement', $reimbursement->tanggal_reimbursement ? \Carbon\Carbon::parse($reimbursement->tanggal_reimbursement)->format('Y-m-d') : '') }}">
                                    @error('tanggal_reimbursement')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="keterangan_reim">Keterangan</label>
                                    <textarea name="keterangan_reim" id="keterangan_reim" rows="5" class="form-control">{{ old('keterangan', $reimbursement->keterangan) }}</textarea>
                                    @error('keterangan_reim')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" id="total_update" class="form-control"
                                        value="{{ old('total', $reimbursement->total) }}">
                                    @error('total')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <script>
                                    var totalInput = document.getElementById('total_update');
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


                                {{-- LAMPIRAN --}}
                                <div class="card-header py-3 mb-2">
                                    {{-- <h6 class="m-0 font-weight-bold text-gray-900 mb-4">Lampiran
                                        Reimbursement
                                    </h6> --}}
                                    <h6 class="m-2 font-weight-bold text-gray-900">Lampiran Reimbursement 1<a
                                            class="text-danger">*</a></h6>
                                </div>
                                {{-- <div class="card-body"> --}}
                                @foreach ($newLampirans as $index => $lampiran)
                                    @if ($index === 1)
                                        <div class="card-header py-3 mt-3 mb-2">
                                            <h6 class="m-0 font-weight-bold text-gray-900">Lampiran
                                                Reimbursement
                                                2</h6>
                                        </div>
                                    @elseif ($index === 2)
                                        <div class="card-header py-3 mt-3 mb-2">
                                            <h6 class="m-0 font-weight-bold text-gray-900">Lampiran
                                                Reimbursement
                                                3</h6>
                                        </div>
                                    @endif

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label">Nomor
                                            Kwitansi</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control mb-1"
                                                aria-describedby="nomor_kwitansi" name="nomor_kwitansi"
                                                value="{{ $lampiran['nomor_kwitansi'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label">Tanggal Kwitansi</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control mb-1" max="{{ date('Y-m-d') }}"
                                                aria-describedby="tanggal_kwitansi" name="tangal_kwitansi"
                                                value="{{ $lampiran['tanggal_kwitansi'] }}">
                                        </div>
                                        @error('tanggal_kwitansi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label">Judul Kwitansi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1"
                                                aria-describedby="judul_kwitansi" name="judul_kwitansi"
                                                value="{{ $lampiran['judul_kwitansi'] }}">
                                        </div>
                                    </div>
                                    <div class=" form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label">Nama Kwitansi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1"
                                                aria-describedby="nama_kwitansi" name="nama_kwitansi"
                                                value="{{ $lampiran['nama_kwitansi'] }}">
                                        </div>
                                    </div>

                                    <div class="form-group mb-1 row">
                                        <label class="col-sm-2 col-form-label"
                                            style="color: black; width: 25%;">File</label>
                                        <div>
                                            <div class="col-sm-10">
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
                                                            target="_blank" class="mb-2">Lihat Detail PDF</a>
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
                                            <textarea class="form-control mb-1" aria-describedby="keterangan" name="keterangan">{{ $lampiran['keterangan'] }}</textarea>
                                        </div>
                                    </div>
                                @endforeach

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
