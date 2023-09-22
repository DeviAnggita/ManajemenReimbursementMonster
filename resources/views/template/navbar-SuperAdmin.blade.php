<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <img class="img-logo" width="200" height="100" src="{{asset('template/img/MONSTER.png')}}">



    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-end flex-column">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ Auth::user()->nama_karyawan }}
                    </span>
                    {{-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ Auth::user()->id_role}} --}}
                        {{-- @if( {{ Auth::user()->id_role}} == 1 )
                        SuperAdmin
                        @endif --}}
                        {{-- </span> --}}
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ Auth::user()->role->nama_role }} - {{ Auth::user()->divisi->nama_divisi }}
                    </span>

                </div>
              
                @if (Auth::user()->foto_profile)
                <style>
                    .img-profile {
                        object-fit: cover;
                        width: 100px; /* Ubah ukuran sesuai preferensi Anda */
                        height: 100px; /* Ubah ukuran sesuai preferensi Anda */
                    }
                </style>
            
                <img class="img-profile rounded-circle" src="{{ asset('FotoProfile/' . Auth::user()->foto_profile) }}" alt="Foto Profil">
            @else
                <img src="{{ asset('template/img/undraw_profile.svg') }}" alt="Foto Profil" class="img-fluid rounded-circle">
            @endif
            


            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <a class="dropdown-item" href="/superadmin/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>

                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="/">Logout</a>
            </div>
        </div>
    </div>
</div>