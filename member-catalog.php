<?php
/*
Member Resource Catalog - 876JA Digital Online Teaching Resources
Private catalog for logged-in subscribers with full download access.
*/

// Require login — redirect guests to login page.
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = '876JA Digital Online Teaching Resources | Member Resource Catalog';
$activePage = 'member-catalog';

function navActive($page, $activePage)
{
    return $page === $activePage ? ' active' : '';
}

// Fetch first name for personalised greeting.
$firstName = $_SESSION['username'] ?? 'Member';

// Load resources from the database.
$resources = [];
try {
    $dbConfig = require __DIR__ . '/database/db-config.php';
    $pdo = new PDO(
        'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . ';charset=utf8mb4',
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Fetch first name.
    $stmt = $pdo->prepare('SELECT first_name FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) $firstName = $user['first_name'];

    // Fetch all resources.
    $stmt = $pdo->query('SELECT id, title, course, type, level FROM resources ORDER BY course, level');
    $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $resources = [];
}

$categories = [
    ['name' => 'Programming',          'icon' => 'bi-code-slash'],
    ['name' => 'Web Development',      'icon' => 'bi-globe2'],
    ['name' => 'Databases',            'icon' => 'bi-database'],
    ['name' => 'Systems Analysis',     'icon' => 'bi-diagram-3'],
    ['name' => 'Networking & Hardware','icon' => 'bi-hdd-network'],
    ['name' => 'Data Structures',      'icon' => 'bi-list-nested'],
];

$typeBadge = [
    'Notes'    => 'bg-primary',
    'Tutorial' => 'bg-success',
    'PDF'      => 'bg-danger',
    'Textbook' => 'bg-info text-dark',
    'Video'    => 'bg-warning text-dark',
];

$levelBadge = [
    'Year 1' => 'badge-soft-blue',
    'Year 2' => 'badge-soft-green',
    'Year 3' => 'badge-soft-gold',
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        .cat-icon-wrap {
            width: 3.2rem; height: 3.2rem; border-radius: 0.9rem;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.4rem; background: rgba(245,197,66,0.13);
            color: #9a6d00; flex-shrink: 0;
        }
        .catalog-filter-bar {
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(15,23,42,0.08);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 0.5rem 1.5rem rgba(31,41,55,0.07);
        }
        .resource-table thead th {
            background: var(--brand-dark); color: #fff;
            font-size: 0.82rem; letter-spacing: 0.07em;
            text-transform: uppercase; border: 0;
        }
        .resource-table thead th:first-child { border-top-left-radius: 0.75rem; }
        .resource-table thead th:last-child  { border-top-right-radius: 0.75rem; }
        .resource-table tbody tr:hover { background: rgba(245,197,66,0.07); }
        .badge-soft-blue  { background: rgba(13,110,253,0.12);  color: #0a58ca; border: 1px solid rgba(13,110,253,0.2); }
        .badge-soft-green { background: rgba(25,135,84,0.12);   color: #146c43; border: 1px solid rgba(25,135,84,0.2); }
        .badge-soft-gold  { background: rgba(245,197,66,0.16);  color: #9a6d00; border: 1px solid rgba(245,197,66,0.25); }
        .badge-soft-blue, .badge-soft-green, .badge-soft-gold {
            font-size: 0.75rem; padding: 0.3em 0.65em;
            border-radius: 0.5rem; font-weight: 600; white-space: nowrap;
        }
        .resource-row.d-none { display: none !important; }
        .category-card.active-filter {
            border: 2px solid var(--brand-gold) !important;
            box-shadow: 0 0.5rem 1.5rem rgba(245,197,66,0.25) !important;
        }
    </style>
</head>
<body>

<!-- ── Member Navigation ── -->
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">876JA Digital Resources</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item"><a class="nav-link<?php echo navActive('dashboard', $activePage); ?>" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('member-catalog', $activePage); ?>" href="member-catalog.php">Resource Catalog</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('payment', $activePage); ?>" href="payment.php">Payments</a></li>
                <li class="nav-item"><a class="nav-login-btn" href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ── Page Banner ── -->
<section class="page-banner">
    <div class="container">
        <h1>Your Resource Catalog</h1>
        <p class="mb-0 mt-2 opacity-75">Welcome, <?php echo htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>! Browse and download your IT course materials below.</p>
    </div>
</section>

<div class="container pb-5">

    <!-- ── Search & Filter Bar ── -->
    <div class="catalog-filter-bar mb-5">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1" for="searchInput">Search Resources</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0"
                           placeholder="e.g. C++, HTML, SQL…" autocomplete="off">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1" for="filterCourse">Course</label>
                <select id="filterCourse" class="form-select">
                    <option value="">All Courses</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1" for="filterLevel">Level</label>
                <select id="filterLevel" class="form-select">
                    <option value="">All Years</option>
                    <option>Year 1</option>
                    <option>Year 2</option>
                    <option>Year 3</option>
                </select>
            </div>
            <div class="col-md-2">
                <button id="resetFilters" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </button>
            </div>
        </div>
    </div>

    <!-- ── Category Cards ── -->
    <h2 class="section-title mb-1">Browse by Course</h2>
    <p class="text-muted mb-4">Click a category to filter resources below.</p>
    <div class="row g-3 mb-5" id="categoryCards">
        <?php foreach ($categories as $cat): ?>
        <div class="col-md-4 col-sm-6">
            <div class="card category-card p-3 h-100"
                 data-category="<?php echo htmlspecialchars($cat['name']); ?>"
                 style="cursor:pointer;">
                <div class="d-flex align-items-center gap-3">
                    <div class="cat-icon-wrap">
                        <i class="bi <?php echo $cat['icon']; ?>"></i>
                    </div>
                    <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($cat['name']); ?></h6>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ── Resource Table ── -->
    <h2 class="section-title mb-1">All Resources</h2>
    <p class="text-muted mb-4" id="resourceCount">
        Showing <?php echo count($resources); ?> resource<?php echo count($resources) !== 1 ? 's' : ''; ?>
    </p>

    <?php if (empty($resources)): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-journal-x fs-1 opacity-50"></i>
        <p class="mt-3">No resources available yet. Check back soon!</p>
    </div>
    <?php else: ?>
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table resource-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th>Level</th>
                        <th class="pe-4 text-end">Download</th>
                    </tr>
                </thead>
                <tbody id="resourceTableBody">
                    <?php foreach ($resources as $r): ?>
                    <tr class="resource-row"
                        data-title="<?php echo strtolower(htmlspecialchars($r['title'])); ?>"
                        data-course="<?php echo htmlspecialchars($r['course']); ?>"
                        data-level="<?php echo htmlspecialchars($r['level']); ?>">
                        <td class="ps-4 fw-semibold">
                            <i class="bi bi-file-earmark-text text-muted me-2"></i>
                            <?php echo htmlspecialchars($r['title']); ?>
                        </td>
                        <td><span class="text-muted small"><?php echo htmlspecialchars($r['course']); ?></span></td>
                        <td>
                            <span class="badge <?php echo $typeBadge[$r['type']] ?? 'bg-secondary'; ?> rounded-pill">
                                <?php echo htmlspecialchars($r['type']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="<?php echo $levelBadge[$r['level']] ?? 'badge-soft-blue'; ?>">
                                <?php echo htmlspecialchars($r['level']); ?>
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="download.php?id=<?php echo (int)$r['id']; ?>" class="btn btn-sm btn-success fw-semibold px-3">
                                <i class="bi bi-download me-1"></i>Download
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="noResults" class="text-center py-5 d-none">
        <i class="bi bi-search fs-1 text-muted opacity-50"></i>
        <p class="mt-3 text-muted">No resources match your search. Try a different filter or keyword.</p>
    </div>
    <?php endif; ?>

</div>

<!-- ── Footer ── -->
<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>876JA Digital Resources</h5>
                <p>Online notes, tutorials, and teaching resources for modern classrooms.</p>
            </div>
            <div class="col-md-4">
                <h5>Member Links</h5>
                <p><a href="dashboard.php">Dashboard</a></p>
                <p><a href="member-catalog.php">Resource Catalog</a></p>
                <p><a href="payment.php">Payments</a></p>
            </div>
            <div class="col-md-4">
                <h5>Support</h5>
                <p><a href="contact.php">Contact Support</a></p>
                <p><a href="faq.php">FAQ</a></p>
                <p><a href="logout.php">Log out</a></p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const searchInput  = document.getElementById('searchInput');
const filterCourse = document.getElementById('filterCourse');
const filterLevel  = document.getElementById('filterLevel');
const resetBtn     = document.getElementById('resetFilters');
const rows         = document.querySelectorAll('.resource-row');
const noResults    = document.getElementById('noResults');
const countLabel   = document.getElementById('resourceCount');
const catCards     = document.querySelectorAll('#categoryCards .category-card');

function applyFilters() {
    const q      = searchInput.value.toLowerCase().trim();
    const course = filterCourse.value;
    const level  = filterLevel.value;
    let visible  = 0;

    rows.forEach(row => {
        const match = (!q      || row.dataset.title.includes(q))
                   && (!course || row.dataset.course === course)
                   && (!level  || row.dataset.level  === level);
        row.classList.toggle('d-none', !match);
        if (match) visible++;
    });

    countLabel.textContent = `Showing ${visible} resource${visible !== 1 ? 's' : ''}`;
    if (noResults) noResults.classList.toggle('d-none', visible > 0);
}

catCards.forEach(card => {
    card.addEventListener('click', () => {
        const selected = card.dataset.category;
        const isSame   = filterCourse.value === selected;
        catCards.forEach(c => c.classList.remove('active-filter'));
        filterCourse.value = isSame ? '' : selected;
        if (!isSame) card.classList.add('active-filter');
        applyFilters();
        document.querySelector('.card.border-0')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

filterCourse.addEventListener('change', () => {
    catCards.forEach(c => c.classList.toggle('active-filter', c.dataset.category === filterCourse.value));
    applyFilters();
});

searchInput.addEventListener('input', applyFilters);
filterLevel.addEventListener('change', applyFilters);

resetBtn.addEventListener('click', () => {
    searchInput.value = ''; filterCourse.value = ''; filterLevel.value = '';
    catCards.forEach(c => c.classList.remove('active-filter'));
    applyFilters();
});
</script>
</body>
</html>
