<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Data Karyawan</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Tabel Data Master Karyawan</h1>
                    <p class="mb-4">Data master karyawan berisikan data karyawan</p>


                    <!-- TAMBAH -->
                    <!-- Tambah Data Karyawan-->
                    {{-- <button href="#"
                                    class="d-none d-sm-inline-block btn btn-primary  btn-sm mb-3 shadow-sm"
                                    data-toggle="modal" data-target="#tambahDataKaryawanModal" type="button">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data Karyawan
                                </button>

                                <!--Modal Tambah Data Karyawan -->
                                @include('SuperAdmin.karyawan.create') --}}



                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-900">Data Tabel Karyawan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- KONTEN -->
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Divisi</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Divisi</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($karyawans as $karyawan)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $karyawan->nomor_identitas_karyawan }}</td>
                                                <td>{{ $karyawan->nama_karyawan }}</td>
                                                <td>{{ $karyawan->nama_divisi }}</td>
                                                <td>{{ $karyawan->email_karyawan }}</td>
                                                <td>{{ $karyawan->nama_role }}</td>
                                                <td>
                                                    @if ($karyawan->status_active == 1)
                                                        <span class="text-primary">Aktif</span> <!-- Warna primary -->
                                                    @else
                                                        <span class="text-danger">Tidak Aktif</span>
                                                        <!-- Warna danger -->
                                                    @endif
                                                </td>
                                                <td class="d-flex">
                                                    {{-- SHOW PEGAWAI --}}
                                                    <button type="button" class="btn btn-info btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#showKaryawanModal-{{ $karyawan->id_user }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    {{-- MODAL SHOW PEGAWAI --}}
                                                    @include('SuperAdmin.karyawan.show')

                                                    <!-- UPDATE KARYAWAN -->
                                                    <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editModalKaryawan{{ $karyawan->id_user }}"> <i
                                                            class="fas fa-edit"></i></button>
                                                    {{-- MODAL UPDATE KARYAWAN --}}
                                                    @include('SuperAdmin.karyawan.update')

                                                    {{-- DELETE KARYAWAN --}}
                                                    <button type="button"
                                                        class="btn btn-danger btn-circle btn-sm flex-end"
                                                        data-toggle="modal"
                                                        data-target="#deleteModalKaryawan{{ $karyawan->id_user }}"><i
                                                            class="fas fa-trash"></i></button>
                                                    {{-- MODAL DELETE KARYAWAN --}}
                                                    @include('SuperAdmin.karyawan.delete')
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
