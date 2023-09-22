<!-- Modal -->
<div class="modal fade" id="editModalLampiran{{$lampiran->id_lampiran}}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{$lampiran->id_lampiran}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{$lampiran->id_lampiran}}" style="color: white;">
                    Edit
                    Lampiran - {{$lampiran->judul_kwitansi}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{route('lampiran.update', $lampiran->id_lampiran)}}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3 row">
                        <label for="reimbursement" class="col-sm-3 col-form-label">Reimbursement</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="reimbursement" name="id_reimbursement">
                                @foreach($reimbursements as $reimbursement)
                                <option value="{{$reimbursement->id_reimbursement}}" @if($lampiran->id_reimbursement ==
                                    $reimbursement->id_reimbursement)
                                    selected
                                    @endif>{{$reimbursement->id_reimbursement}}</option>
                                @endforeach
                            </select>
                            @error('id_reimbursement')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="nomor_kwitansi" class="col-sm-3 col-form-label">Nomor Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nomor_kwitansi" name="nomor_kwitansi"
                                value="{{$lampiran->nomor_kwitansi}}">
                            @error('nomor_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <label for="judul_kwitansi" class="col-sm-3 col-form-label">Judul Lampiran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="judul_kwitansi" name="judul_kwitansi"
                                value="{{$lampiran->judul_kwitansi}}">
                            @error('judul_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="nama_kwitansi" class="col-sm-3 col-form-label">Nama Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_kwitansi" name="nama_kwitansi"
                                value="{{$lampiran->nama_kwitansi}}">
                            @error('nama_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <label for="jenis_reimbursement" class="col-sm-3 col-form-label">Reimbursement</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenis_reimbursement" name="id_jenis_reimbursement">
                                @foreach($jenis_reimbursements as $jenis_reimbursement)
                                <option value="{{$jenis_reimbursement->id_jenis_Reimbursement}}" @if($lampiran->
                                    id_jenis_reimbursement ==
                                    $jenis_reimbursement->id_jenis_reimbursement)
                                    selected
                                    @endif>{{$jenis_reimbursement->nama_jenis_reimbursement}}</option>
                                @endforeach
                            </select>
                            @error('id_jenis_reimbursement')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <label for="supplier" class="col-sm-3 col-form-label">Supplier</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="supplier" name="id_supplier">
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id_supplier}}" @if($lampiran->id_supplier ==
                                    $supplier->id_supplier)
                                    selected
                                    @endif>{{$supplier->nama_supplier}}</option>
                                @endforeach
                            </select>
                            @error('id_supplier')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <label for="file" class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="file" name="file" value="{{$lampiran->file}}">
                            @error('file')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                value="{{$lampiran->keterangan}}">
                            @error('keterangan')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <label for="tanggal_kwitansi" class="col-sm-3 col-form-label">Tanggal Kwitansi</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" class=" form-control" id="tanggal_kwitansi"
                                name="tanggal_kwitansi" value="{{$lampiran->tanggal_kwitansi}}">
                            @error('tanggal_kwitansi')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
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