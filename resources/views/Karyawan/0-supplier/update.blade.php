<!-- Modal -->
<div class="modal fade" id="editModalSupplier{{$supplier->id_supplier}}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{$supplier->id_supplier}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-900">
                <h5 class="modal-title" id="editModalLabel{{$supplier->id_supplier}}" style="color: white;">
                    Edit
                    Supplier - {{$supplier->nama_supplier}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{route('supplier.update', $supplier->id_supplier)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3 row">
                        <label for="nama_supplier" class="col-sm-3 col-form-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier"
                                value="{{$supplier->nama_supplier}}">
                            @error('nama_supplier')
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