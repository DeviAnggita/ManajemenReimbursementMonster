<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">Manajemen <sup>Reimbursement</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/manajer-keuangan/dashboard/">
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
        <a class="nav-link" href="/manajer-keuangan/verifikasi">
            <i class="fas fa fa-check-circle"></i>
            <span>Verifikasi Reimbursement</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fa fa-check"></i>
            <span>Riwayat Status Verifikasi </span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Status Verifikasi :</h6>
                <a class="collapse-item" href="/manajer-keuangan/setuju-verifikasi">Disetujui</a>
                <a class="collapse-item" href="/manajer-keuangan/revisi-verifikasi">Perlu Revisi</a>
                <a class="collapse-item" href="/manajer-keuangan/tolak-verifikasi">Ditolak</a>
                {{-- <a class="collapse-item" href="/manajer-keuangan/selesai-reimbursement">Selesai</a> --}}
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Riwayat Jenis Verifikasi </span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Verifikasi :</h6>
                <a class="collapse-item" href="/manajer-keuangan/medical-verifikasi">Medical</a>
                <a class="collapse-item" href="/manajer-keuangan/perjalanan-bisnis-verifikasi">Perjalanan Bisnis</a>
                <a class="collapse-item" href="/manajer-keuangan/penunjang-kantor-verifikasi">Penunjang Kantor</a>
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

        // Close collapse Pages when clicking on Dashboard or Verifikasi Reimbursement
        const dashboardLink = document.querySelector(
            ".nav-item .nav-link[href='/manajer-keuangan/dashboard/']");
        const verifikasiLink = document.querySelector(
            ".nav-item .nav-link[href='/manajer-keuangan/verifikasi']");
        const collapsePages = document.querySelector("#collapsePages");

        dashboardLink.addEventListener("click", function() {
            collapsePages.classList.remove("show");
        });

        verifikasiLink.addEventListener("click", function() {
            collapsePages.classList.remove("show");
        });

        // Show collapse Pages and set submenu active when clicking on Menunggu Persetujuan, Setuju Reimbursement, Revisi Reimbursement, or Tolak Reimbursement
        const menungguVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/menunggu-verifikasi']");
        const setujuVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/setuju-verifikasi']");
        const revisiVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/revisi-verifikasi']");
        const tolakVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/tolak-verifikasi']");
        const selesaiReimbursementSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/selesai-reimbursement']");


        const collapseInner = document.querySelector(".bg-white.py-2.collapse-inner.rounded");

        if (menungguVerifikasiSubMenu && menungguVerifikasiSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            menungguVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = menungguVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        } else if (setujuVerifikasiSubMenu && setujuVerifikasiSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            setujuVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = setujuVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        } else if (revisiVerifikasiSubMenu && revisiVerifikasiSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            revisiVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = revisiVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");


        } else if (tolakVerifikasiSubMenu && tolakVerifikasiSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            tolakVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = tolakVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");

        } else if (selesaiReimbursementSubMenu && selesaiReimbursementSubMenu.href === currentLocation) {
            collapsePages.classList.add("show");
            selesaiReimbursementSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = selesaiReimbursementSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        }

        // Show collapse Two and set submenu active when clicking on Medical, Perjalanan Bisnis, or Penunjang Kantor
        const medicalVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/medical-verifikasi']");
        const perjalananBisnisVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/perjalanan-bisnis-verifikasi']");
        const penunjangKantorVerifikasiSubMenu = document.querySelector(
            ".collapse-item[href='/manajer-keuangan/penunjang-kantor-verifikasi']");
        const collapseTwo = document.querySelector("#collapseTwo");

        if (medicalVerifikasiSubMenu && medicalVerifikasiSubMenu.href === currentLocation) {
            collapseTwo.classList.add("show");
            medicalVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = medicalVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        } else if (perjalananBisnisVerifikasiSubMenu && perjalananBisnisVerifikasiSubMenu.href ===
            currentLocation) {
            collapseTwo.classList.add("show");
            perjalananBisnisVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = perjalananBisnisVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        } else if (penunjangKantorVerifikasiSubMenu && penunjangKantorVerifikasiSubMenu.href ===
            currentLocation) {
            collapseTwo.classList.add("show");
            penunjangKantorVerifikasiSubMenu.classList.add("active");
            collapseInner.style.display = "block";

            // Remove active class from parent nav-item if any
            const parentNavItem = penunjangKantorVerifikasiSubMenu.closest(".nav-item");
            const parentNavItems = document.querySelectorAll(".nav-item");
            parentNavItems.forEach(function(item) {
                item.classList.remove("active");
            });
            parentNavItem.classList.add("active");
        }
    });
</script>
