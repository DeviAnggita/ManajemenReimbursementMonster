<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Data Status Pengajuan</title>

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
                @include('template.navbar-SuperAdmin')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tabel Data Master Status Pengajuan</h1>
                    <p class="mb-4">Data master status pengajuan berisikan data status pengajuan</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">Data Tabel Status Pengajuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- TAMBAH -->
                                <!-- Tambah Data Strata-->
                                {{-- <button href="#"
                                    class="d-none d-sm-inline-block btn btn-primary  btn-sm mb-3 shadow-sm"
                                    data-toggle="modal" data-target="#tambahDataStatusPengajuanModal" type="button">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data Status Pengajuan
                                </button> --}}

                                <!--Modal Tambah Data Strata  -->
                                {{-- @include('SuperAdmin.status-pengajuan.create') --}}

                                {{-- <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <label for="sortOption">Sort by : </label>
                                        <select id="sortOption" name="sortOption"
                                            class="custom-select-sm form-control-sm">
                                            <option value="all">All</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="d-flex align-items-center ml-3 mb-2">
                                        <label for="sortOption">Sort by:
                                            <select id="sortOption" name="sortOption" aria-controls="dataTable"
                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="all">All</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select></label>
                                    </div>
                                </div>

                                <!-- KONTEN -->
                                <table class="table table-bordered" id="dataTableStatusPengajuan" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status Pengajuan</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Status Pengajuan</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot> --}}

                                    <tbody id="tableBodyContainer">
                                        @php $no = 1; @endphp
                                        @foreach ($statuspengajuans as $statuspengajuan)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $statuspengajuan->nama_status_pengajuan }}</td>
                                                <td>{{ $statuspengajuan->nama_role }}</td>
                                                <td>
                                                    @if ($statuspengajuan->status_active == 1)
                                                        <span class="text-primary">Aktif</span> <!-- Warna primary -->
                                                    @else
                                                        <span class="text-danger">Tidak Aktif</span>
                                                        <!-- Warna danger -->
                                                    @endif
                                                </td>
                                                <td class="d-flex">
                                                    {{-- SHOW STRATA --}}
                                                    {{-- <button type="button" class="btn btn-info btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#showStatusPengajuanModal-{{ $statuspengajuan->id_status_pengajuan }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    MODAL SHOW STRATA
                                                    @include('SuperAdmin.status-pengajuan.show') --}}

                                                    <!-- UPDATE STRATA -->
                                                    {{-- @if (in_array($reimbursement->id_status_pengajuan, $allowedStatus->pluck('id_status_pengajuan')->toArray())) --}}
                                                    <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editModalStatusPengajuan{{ $statuspengajuan->id_status_pengajuan }}">
                                                        <i class="fas fa-edit"></i></button>
                                                    {{-- MODAL UPDATE STRATA --}}
                                                    @include('SuperAdmin.status-pengajuan.update')
                                                    {{-- @endif --}}


                                                    {{-- <!-- UPDATE MEDICAL -->
                                                    @if (in_array($reimbursement->id_status_pengajuan, $allowedStatus->pluck('id_status_pengajuan')->toArray()))
                                                        <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editModalVerifReimbursement{{ $reimbursement->id_reimbursement }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <!-- MODAL UPDATE Medical -->
                                                        @include('Karyawan.medical.updateStatus')
                                                    @endif
 --}}




                                                    {{-- DELETE STRATA --}}
                                                    {{-- <button type="button"
                                                        class="btn btn-danger btn-circle btn-sm flex-end"
                                                        data-toggle="modal"
                                                        data-target="#deleteModalStatusPengajuan{{ $statuspengajuan->id_status_pengajuan }}"><i
                                                            class="fas fa-trash"></i></button> --}}
                                                    {{-- MODAL DELETE STRATA --}}
                                                    {{-- @include('SuperAdmin.status-pengajuan.delete') --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        // Cache the table body container
                                        var $tableBodyContainer = $('#tableBodyContainer');

                                        // Handle the change event of the sort option
                                        $('#sortOption').change(function() {
                                            var selectedOption = $(this).val();

                                            // Hide all rows by default
                                            $tableBodyContainer.find('tr').hide();

                                            if (selectedOption === 'all') {
                                                // Show all rows
                                                $tableBodyContainer.find('tr').show();
                                            } else {
                                                // Show rows based on the selected option
                                                $tableBodyContainer.find('tr').each(function() {
                                                    var status = $(this).find('td:nth-child(4)').text().trim();

                                                    if ((selectedOption === 'Aktif' && status === 'Aktif') ||
                                                        (selectedOption === 'Tidak Aktif' && status === 'Tidak Aktif')) {
                                                        $(this).show();
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>
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
