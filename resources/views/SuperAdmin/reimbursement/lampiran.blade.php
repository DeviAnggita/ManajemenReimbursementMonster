<div id="formTambahLampiran" class="collapse">
    <form method="POST" action="{{route('lampiran.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-1 row">
            <label for="nomor_kwitansi_create" class="col-sm-2 col-form-label">Nomor Kwitansi</label>
            <div class="col-sm-10">
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
            <label for="judul_kwitansi_create" class="col-sm-2 col-form-label">Judul Lampiran</label>
            <div class="col-sm-10">
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
            <label for="nama_kwitansi_create" class="col-sm-2 col-form-label">Nama Kwitansi</label>
            <div class="col-sm-10">
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
            <label for="file_create" class="col-sm-2 col-form-label">File</label>
            <div class="col-sm-10">
                <input type="file" class="form-control @error('file') is-invalid @enderror mb-1" id="file_create"
                    aria-describedby="file" name="file" value="{{ old('file') }}" required>


                @error('file')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>


        <div class="form-group mb-1 row">
            <label for="keterangan_create" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control @error('keterangan') is-invalid @enderror mb-1"
                    id="keterangan_create" aria-describedby="keterangan" name="keterangan"
                    value="{{ old('keterangan') }}" required></textarea>
                @error('keterangan')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>



        <div class="form-group mb-1 row">
            <label for="tanggal_kwitansi_create" class="col-sm-2 col-form-label">Tanggal Kwitansi</label>
            <div class="col-sm-10">
                <input type="date" class="form-control @error('tanggal_kwitansi') is-invalid @enderror mb-1"
                    id="tanggal_kwitansi_create" aria-describedby="tanggal_kwitansi" name="tanggal_kwitansi"
                    value="{{ old('tanggal_kwitansi') }}" required>
                @error('tanggal_kwitansi')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        {{-- <div class="form-group mb-1 row">
            <label for="" class="col-sm-10 col-form-label"></label>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-warning mb-3 mr-10 ml-auto">Simpan Lampiran</button>
            </div>
        </div> --}}
    </form>
</div>



{{-- <div class="form-group">
    <label for="nomor_kwitansi">Nomor Kwitansi</label>
    <input type="text" class="form-control" id="nomor_kwitansi" name="nomor_kwitansi">
</div>

<div class="form-group">
    <label for="tanggal_kwitansi">Tanggal Kwitansi</label>
    <input type="date" class="form-control" id="tanggal_kwitansi" name="tanggal_kwitansi">
</div>

<div class="form-group">
    <label for="judul_kwitansi">Judul Kwitansi</label>
    <input type="text" class="form-control" id="judul_kwitansi" name="judul_kwitansi">
</div>

<div class="form-group">
    <label for="nama_lampiran">Nama Lampiran</label>
    <input type="text" class="form-control" id="nama_lampiran" name="nama_lampiran">
</div>

<div class="form-group">
    <label for="file_upload">File Upload</label>
    <input type="file" class="form-control-file" id="file_upload" name="file_upload">
</div>

<div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
</div> --}}