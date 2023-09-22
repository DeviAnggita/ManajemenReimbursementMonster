<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Data Jenis Reimbursement</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Table Data Master Jenis Reimbursement</h1>
                    <p class="mb-4">Data master jenis reimbursement berisikan data jenis reimbursement</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">DataTables Jenis Reimbursement</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- TAMBAH -->
                                <!-- Tambah Data Jenis Reimbursement-->
                                <button href="#" class="d-none d-sm-inline-block btn btn-primary  btn-sm mb-3 shadow-sm"
                                    data-toggle="modal" data-target="#tambahDataJenisReimbursementModal" type="button">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data Jenis Reimbursement
                                </button>

                                <!--Modal Tambah Data Jenis Reimbursement  -->
                                @include('SuperAdmin.jenisreimbursement.create')


                                <!-- KONTEN -->
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier</th>
                                            <th>Proyek</th>
                                            <th>Nama Jenis Reimbursement</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier</th>
                                            <th>Proyek</th>
                                            <th>Nama Jenis Reimbursement</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($jenisreimbursements as $jenisreimbursement)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                @if ($jenisreimbursement->memiliki_supplier == 1)
                                                Memiliki supplier
                                                @else
                                                Tidak memiliki supplier
                                                @endif
                                            </td>
                                            <td>
                                                @if ($jenisreimbursement->memiliki_proyek == 1)
                                                Memiliki proyek
                                                @else
                                                Tidak memiliki proyek
                                                @endif
                                            </td>
                                            <td>{{ $jenisreimbursement->nama_jenis_reimbursement }}</td>
                                            <td class="d-flex">
                                                {{-- SHOW STRATA --}}
                                                <button type="button" class="btn btn-info btn-circle btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#showJenisReimbursementModal-{{ $jenisreimbursement->id_jenis_reimbursement }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                {{-- MODAL SHOW STRATA --}}
                                                @include('SuperAdmin.jenisreimbursement.show')

                                                <!-- UPDATE STRATA -->
                                                <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editModalJenisReimbursement{{$jenisreimbursement->id_jenis_reimbursement}}">
                                                    <i class="fas fa-edit"></i></button>
                                                {{-- MODAL UPDATE STRATA--}}
                                                @include('SuperAdmin.jenisreimbursement.update')

                                                {{-- DELETE STRATA --}}
                                                <button type="button" class="btn btn-danger btn-circle btn-sm flex-end"
                                                    data-toggle="modal"
                                                    data-target="#deleteModalJenisReimbursement{{ $jenisreimbursement->id_jenis_reimbursement }}"><i
                                                        class="fas fa-trash"></i></button>
                                                {{-- MODAL DELETE STRATA --}}
                                                @include('SuperAdmin.jenisreimbursement.delete')
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