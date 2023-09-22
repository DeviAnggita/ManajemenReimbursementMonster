<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Manajemen <sup>Reimbursement</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/karyawan/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Main Menu
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/karyawan/reimbursement">
            <i class="fas fa-fw fa-folder"></i>
            <span>Formulir Reimbursement</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Riwayat Reimbursement</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Reimbursement :</h6>
                <a class="collapse-item" href="/karyawan/medical">Medical</a>
                <a class="collapse-item" href="/karyawan/perjalanan-bisnis">Perjalanan Bisnis</a>
                <a class="collapse-item" href="/karyawan/penunjang-kantor">Penunjang Kantor</a>
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
        const dashboardLink = document.querySelector(".nav-item .nav-link[href='/karyawan/dashboard']");
        const reimbursementLink = document.querySelector(".nav-item .nav-link[href='/karyawan/reimbursement']");
        const collapsePages = document.querySelector("#collapsePages");

        dashboardLink.addEventListener("click", function() {
            collapsePages.classList.remove("show");
        });

        reimbursementLink.addEventListener("click", function() {
            collapsePages.classList.remove("show");
        });

        // Show collapse Pages and set submenu active when clicking on Medical, Perjalanan Bisnis, or Penunjang Kantor
        const medicalSubMenu = document.querySelector(".collapse-item[href='/karyawan/medical']");
        const perjalananBisnisSubMenu = document.querySelector(
            ".collapse-item[href='/karyawan/perjalanan-bisnis']");
        const penunjangKantorSubMenu = document.querySelector(
            ".collapse-item[href='/karyawan/penunjang-kantor']");
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
    });
</script>
