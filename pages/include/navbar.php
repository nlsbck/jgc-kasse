<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= URI->getURI('home') ?>">JGC Kasse</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= URI->getURI('home') ?>">Start</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URI->getURI('revenues') ?>">Umsätze</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URI->getURI('finalize') ?>">Abschluss</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Datenpflege
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= URI->getURI('cash-registers') ?>">Kassen</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= URI->getURI('initial-cash-status') ?>">Initialer Kassenstand</a></li>
                        <li>
                        <li>
                            <a class="dropdown-item" href="<?= URI->getURI('tax-rates') ?>">Steuersätze</a></li>
                        <li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.querySelectorAll('.nav-link').forEach(navLink => {
        if (navLink.href === '<?= URI->getURI()?>') {
            navLink.classList.add('active');
        } else {
            navLink.classList.remove('active');
        }
    })
</script>