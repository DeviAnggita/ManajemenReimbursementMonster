<div class="modal fade" id="showSupplierModal-{{ $supplier->id_supplier }}" tabindex="-1" role="dialog"
    aria-labelledby="showSupplierLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gray-900">
                    <h5 class="modal-title" id="showSupplierLabel" style="color: white;">Detail Supplier</h5>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <div class="form-group mb-1 row">
                        <label class="col-sm-3 col-form-label" style="color: black; width: 25%;">Nama Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext mb-1" aria-describedby="nama_supplier"
                                name="nama_supplier" style="color: #1f1f1f; width: 300px;"
                                value="{{ $supplier->nama_supplier }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>