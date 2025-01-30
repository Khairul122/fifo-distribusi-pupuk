<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="d-none d-md-inline">
                        <?php echo $_SESSION['nama_lengkap'] ?? 'Guest'; ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>