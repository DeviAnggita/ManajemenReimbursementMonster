<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Karyawan - Data Supplier</title>

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
                @include('template.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables Data Supplier</h1>
                    <p class="mb-4">Data Master Supplier</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">DataTables Supplier</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- TAMBAH -->
                                <!-- Tambah Data Supplier-->
                                <button href="#" class="d-none d-sm-inline-block btn btn-primary  btn-sm mb-3 shadow-sm"
                                    data-toggle="modal" data-target="#tambahDataSupplierModal" type="button">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data Supplier
                                </button>

                                <!--Modal Tambah Data Supplier  -->
                                @include('Karyawan.supplier.create')


                                <!-- KONTEN -->
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Supplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Supplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $supplier->nama_supplier }}</td>
                                            <td class="d-flex">
                                                {{-- SHOW SUPPLIER --}}
                                                <button type="button" class="btn btn-info btn-circle btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#showSupplierModal-{{ $supplier->id_supplier }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                {{-- MODAL SHOW SUPPLIER --}}
                                                @include('Karyawan.supplier.show')

                                                <!-- UPDATE SUPPLIER  -->
                                                <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editModalSupplier{{$supplier->id_supplier}}"> <i
                                                        class="fas fa-edit"></i></button>
                                                {{-- MODAL UPDATE SUPPLIER --}}
                                                @include('Karyawan.supplier.update')

                                                {{-- DELETE SUPPLIER --}}
                                                <button type="button" class="btn btn-danger btn-circle btn-sm flex-end"
                                                    data-toggle="modal"
                                                    data-target="#deleteModalSupplier{{ $supplier->id_supplier }}"><i
                                                        class="fas fa-trash"></i></button>
                                                {{-- MODAL DELETE Supplier --}}
                                                @include('Karyawan.supplier.delete')
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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