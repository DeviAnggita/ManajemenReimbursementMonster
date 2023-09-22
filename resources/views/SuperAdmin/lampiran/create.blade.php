<div class="modal fade" id="tambahDataLampiranModal" tabindex="-1" role="dialog"
    aria-labelledby="tambahDataLampiranLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('lampiran.store') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="tambahDataLampiranLabel" style="color: white;">Tambah Lampiran</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>




                <div class="modal-body" style="color: black;">

                    <div class="form-group mb-1 row">
                        <label for="id_reimbursement_create" class="col-sm-3 col-form-label">Reimbursement</label>
                        <div class="col-sm-9">
                            <select name="id_reimbursement" id="id_reimbursement_create"
                                class="form-control mb-1 shadow-none" required>
                                <option disabled selected="">Pilih Reimbursement</option>
                                @foreach ($reimbursements as $reimbursement)
                                <option value="{{ $reimbursement->id_reimbursement }}">
                                    {{ $reimbursement->id_reimbursement }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_reimbursement')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="nomor_kwitansi_create" class="col-sm-3 col-form-label">Nomor Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nomor_kwitansi') is-invalid @enderror mb-1"
                                id="nomor_kwitansi_create" aria-describedby="nomor_kwitansi" name="nomor_kwitansi"
                                value="{{ old('nomor_kwitansi') }}" required>
                            @error('nomor_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="judul_kwitansi_create" class="col-sm-3 col-form-label">Judul Lampiran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('judul_kwitansi') is-invalid @enderror mb-1"
                                id="judul_kwitansi_create" aria-describedby="judul_kwitansi" name="judul_kwitansi"
                                value="{{ old('judul_kwitansi') }}" required>
                            @error('judul_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="nama_kwitansi_create" class="col-sm-3 col-form-label">Nama Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nama_kwitansi') is-invalid @enderror mb-1"
                                id="nama_kwitansi_create" aria-describedby="nama_kwitansi" name="nama_kwitansi"
                                value="{{ old('nama_kwitansi') }}" required>
                            @error('nama_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label for="id_jenis_reimbursement_create" class="col-sm-3 col-form-label">
                            Reimbursement</label>
                        <div class="col-sm-9">
                            <select name="id_jenis_reimbursement" id="id_jenis_reimbursement_create"
                                class="form-control mb-1 shadow-none" required>
                                <option disabled selected="">Pilih Jenis Reimbursement</option>
                                @foreach ($jenis_reimbursements as $jenis_reimbursement)
                                <option value="{{ $jenis_reimbursement->id_jenis_reimbursement }}">
                                    {{ $jenis_reimbursement->nama_jenis_reimbursement }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_jenis_reimbursement')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label for="id_supplier_create" class="col-sm-3 col-form-label">Supplier</label>
                        <div class="col-sm-9">
                            <select name="id_supplier" id="id_supplier_create" class="form-control mb-1 shadow-none"
                                required>
                                <option disabled selected="">Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}">
                                    {{ $supplier->nama_supplier }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_supplier')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group mb-1 row">
                        <label for="file_create" class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('file') is-invalid @enderror mb-1"
                                id="file_create" aria-describedby="file" name="file" value="{{ old('file') }}" required>


                            @error('file')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-1 row">
                        <label for="keterangan_create" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror mb-1"
                                id="keterangan_create" aria-describedby="keterangan" name="keterangan"
                                value="{{ old('keterangan') }}" required>
                            @error('keterangan')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group mb-1 row">
                        <label for="tanggal_kwitansi_create" class="col-sm-3 col-form-label">Tanggal Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="datetime-local"
                                class="form-control @error('tanggal_kwitansi') is-invalid @enderror mb-1"
                                id="tanggal_kwitansi_create" aria-describedby="tanggal_kwitansi" name="tanggal_kwitansi"
                                value="{{ old('tanggal_kwitansi') }}" required>
                            @error('tanggal_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
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