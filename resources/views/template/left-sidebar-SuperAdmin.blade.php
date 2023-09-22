<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">Manajemen <sup>Reimbursement</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/superadmin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data:</h6>
                <a class="collapse-item" href="/superadmin/karyawan">Data User</a>
                <a class="collapse-item" href="/superadmin/divisi">Data Divisi</a>
                <a class="collapse-item" href="/superadmin/strata">Data Strata</a>
                <a class="collapse-item" href="/superadmin/role">Data Role</a>
                <a class="collapse-item" href="/superadmin/supplier">Data Supplier</a>
                <a class="collapse-item" href="/superadmin/proyek">Data Proyek</a>
                <a class="collapse-item" href="/superadmin/status-pengajuan">Data Status Pengajuan</a>
                {{-- <a class="collapse-item" href="/superadmin/jenisreimbursement">Data Jenis Reimbursement</a> --}}
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Main Menu
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/superadmin/reimbursement">
            <i class="fas fa-fw fa-folder"></i>
            <span>Formulir Reimbursement</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Laporan Reimbursement</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Reimbursement :</h6>
                <a class="collapse-item" href="/superadmin/medical">Medical</a>
                <a class="collapse-item" href="/superadmin/perjalanan-bisnis">Perjalanan Bisnis</a>
                <a class="collapse-item" href="/superadmin/penunjang-kantor">Penunjang Kantor</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<script>
    // JavaScript code to update active menu item based on URL
    document.addEventListener("DOMContentLoaded", function() {
        const currentLocation = location.href;
        const navItems = document.querySelectorAll(".nav-item");
        navItems.forEach(function(item) {
            if (item.querySelector("a").href === currentLocation) {
                item.classList.add("active");
            } else {
                item.classList.remove("active");
            }
        });

        // Close collapse Pages when clicking on Dashboard or Formulir Reimbursement
        const dashboardLink = document.querySelector(".nav-item .nav-link[href='/superadmin/dashboard']");
        const reimbursementLink = document.querySelector(
            ".nav-item .nav-link[href='/superadmin/reimbursement']");
        const collapsePages = document.querySelector("#collapsePages");

        dashboardLink.addEventListener("click", function() {
            collapsePages.classList.remove("show");
        });

        reimbursementLink.addEventListener("click", function() {
            collapsePages.classList.remove("show");
        });

        // Show collapse Pages and set submenu active when clicking on Medical, Perjalanan Bisnis, or Penunjang Kantor
        const medicalSubMenu = document.querySelector(".collapse-item[href='/superadmin/medical']");
        const perjalananBisnisSubMenu = document.querySelector(
            ".collapse-item[href='/superadmin/perjalanan-bisnis']");
        const penunjangKantorSubMenu = document.querySelector(
            ".collapse-item[href='/superadmin/penunjang-kantor']");
        const collapseInner = document.querySelector(".bg-white.py-2.collapse-inner.rounded");

        if (medicalSubMenu && medicalSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            medicalSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = medicalSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        } else if (perjalananBisnisSubMenu && perjalananBisnisSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            perjalananBisnisSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = perjalananBisnisSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        } else if (penunjangKantorSubMenu && penunjangKantorSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            penunjangKantorSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = penunjangKantorSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        }

        // Get submenu data elements
        const submenuDataItems = document.querySelectorAll("#collapseTwo .collapse-item");

        // Loop through submenu data items
        submenuDataItems.forEach(function(item) {
            // Check if item href matches current location
            if (item.href === currentLocation) {
                // Add active class to item
                item.classList.add("active");

                // Expand the submenu
                const collapseTwo = document.querySelector("#collapseTwo");
                collapseTwo.classList.add("show");

                // Add active class to parent nav-item
                const parentNavItem = item.closest(".nav-item");
                parentNavItem.classList.add("active");

                // Add active class to Interface heading
                const interfaceHeading = document.querySelector(".sidebar-heading:nth-of-type(1)");
                interfaceHeading.classList.add("active");
            }
        });
    });
</script>
