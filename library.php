<?php
/*
Resource Catalog - 876JA Digital Online Teaching Resources
Public page for browsing IT learning resources by course category.
*/

// Public page â€” visitors can browse, logged-in members get download access.
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

$pageTitle = '876JA Digital Online Teaching Resources | Resource Catalog';
$activePage = 'library';

// Helper to set active nav class.
function navActive($page, $activePage)
{
    return $page === $activePage ? ' active' : '';
}

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
    $stmt = $pdo->query('SELECT id, title, course, type, level FROM resources ORDER BY course, level');
    $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Silently fall back to empty list â€” page still renders.
    $resources = [];
}

$categories = [
    ['name' => 'Programming',         'icon' => 'bi-code-slash',         'desc' => 'Core programming concepts, C++, Python, and algorithm fundamentals.'],
    ['name' => 'Web Development',     'icon' => 'bi-globe2',             'desc' => 'HTML, CSS, JavaScript, PHP, and full-stack web technologies.'],
    ['name' => 'Databases',           'icon' => 'bi-database',           'desc' => 'Database design, SQL, normalization, and MySQL practicals.'],
    ['name' => 'Systems Analysis',    'icon' => 'bi-diagram-3',          'desc' => 'SDLC, use cases, data flow diagrams, and system design.'],
    ['name' => 'Networking & Hardware','icon' => 'bi-hdd-network',       'desc' => 'Network topologies, protocols, hardware components, and troubleshooting.'],
    ['name' => 'Data Structures',     'icon' => 'bi-list-nested',        'desc' => 'Arrays, linked lists, stacks, queues, trees, and sorting algorithms.'],
];

// Type badge colour map.
$typeBadge = [
    'Notes'    => 'bg-primary',
    'Tutorial' => 'bg-success',
    'PDF'      => 'bg-danger',
    'Video'    => 'bg-warning text-dark',
];

// Level badge colour map.
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
    <link rel="icon" type="image/png" href="assets/css/images/876Logo.png">
    <style>
        /* â”€â”€ Catalog-specific styles (extends styles.css) â”€â”€ */

        .catalog-filter-bar {
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(15,23,42,0.08);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 0.5rem 1.5rem rgba(31,41,55,0.07);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
        }

        /* Category cards with icon */
        .cat-icon-wrap {
            width: 3.2rem;
            height: 3.2rem;
            border-radius: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            background: rgba(245,197,66,0.13);
            color: #9a6d00;
            flex-shrink: 0;
        }

        /* Resource table */
        .resource-table thead th {
            background: var(--brand-dark);
            color: #fff;
            font-size: 0.82rem;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            border: 0;
        }

        .resource-table thead th:first-child { border-top-left-radius: 0.75rem; }
        .resource-table thead th:last-child  { border-top-right-radius: 0.75rem; }

        .resource-table tbody tr {
            transition: background 0.15s ease;
        }

        .resource-table tbody tr:hover {
            background: rgba(245,197,66,0.07);
        }

        /* Soft level badges */
        .badge-soft-blue  { background: rgba(13,110,253,0.12);  color: #0a58ca; border: 1px solid rgba(13,110,253,0.2); }
        .badge-soft-green { background: rgba(25,135,84,0.12);   color: #146c43; border: 1px solid rgba(25,135,84,0.2); }
        .badge-soft-gold  { background: rgba(245,197,66,0.16);  color: #9a6d00; border: 1px solid rgba(245,197,66,0.25); }

        .badge-soft-blue,
        .badge-soft-green,
        .badge-soft-gold {
            font-size: 0.75rem;
            padding: 0.3em 0.65em;
            border-radius: 0.5rem;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Smooth hidden rows for filter */
        .resource-row.d-none { display: none !important; }

        /* Active category highlight */
        .category-card.active-filter {
            border: 2px solid var(--brand-gold) !important;
            box-shadow: 0 0.5rem 1.5rem rgba(245,197,66,0.25) !important;
        }
    </style>
</head>
<body>

<!-- â”€â”€ Navigation â”€â”€ -->
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">876JA Digital Resources</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?php echo navActive('home', $activePage); ?>"    href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('about', $activePage); ?>"   href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link"                                                  href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('faq', $activePage); ?>"     href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Library</a></li>
                <?php if ($isLoggedIn): ?>
                <li class="nav-item"><a class="nav-login-btn" href="dashboard.php">Dashboard</a></li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-login-btn" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- â”€â”€ Page Banner â”€â”€ -->
<section class="page-banner">
    <div class="container">
        <h1>Resource Catalog</h1>
        <p class="mb-0 mt-2 opacity-75">Browse IT course materials by category â€” notes, tutorials, and more.</p>
    </div>
</section>

<div class="container pb-5">

    <!-- â”€â”€ Search & Filter Bar â”€â”€ -->
    <div class="catalog-filter-bar mb-5">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1" for="searchInput">Search Resources</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0"
                           placeholder="e.g. C++, HTML, SQLâ€¦" autocomplete="off">
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

    <!-- â”€â”€ Course Categories â”€â”€ -->
    <h2 class="section-title mb-1">Browse by Course</h2>
    <p class="text-muted mb-4">Click a category to filter the resource list below.</p>

    <div class="row g-3 mb-5" id="categoryCards">
        <?php foreach ($categories as $cat): ?>
        <div class="col-md-4 col-sm-6">
            <div class="card category-card p-3 h-100 cursor-pointer"
                 data-category="<?php echo htmlspecialchars($cat['name']); ?>"
                 style="cursor:pointer;">
                <div class="d-flex align-items-start gap-3">
                    <div class="cat-icon-wrap mt-1">
                        <i class="bi <?php echo $cat['icon']; ?>"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($cat['name']); ?></h6>
                        <p class="text-muted mb-0 small"><?php echo htmlspecialchars($cat['desc']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- â”€â”€ Resource Table â”€â”€ -->
    <h2 class="section-title mb-1">All Resources</h2>
    <p class="text-muted mb-4" id="resourceCount">
        Showing <?php echo count($resources); ?> resource<?php echo count($resources) !== 1 ? 's' : ''; ?>
    </p>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table resource-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th>Level</th>
                        <th class="pe-4 text-end">Action</th>
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
                        <td>
                            <span class="text-muted small"><?php echo htmlspecialchars($r['course']); ?></span>
                        </td>
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
                            <?php if ($isLoggedIn): ?>
                                <a href="download.php?id=<?php echo (int)$r['id']; ?>" class="btn btn-sm btn-success fw-semibold px-3">
                                    <i class="bi bi-download me-1"></i>Download
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-sm btn-warning fw-semibold px-3">
                                    <i class="bi bi-lock-fill me-1"></i>Members Only
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- No results message -->
    <div id="noResults" class="text-center py-5 d-none">
        <i class="bi bi-search fs-1 text-muted opacity-50"></i>
        <p class="mt-3 text-muted">No resources match your search. Try a different filter or keyword.</p>
    </div>

    <!-- â”€â”€ Members CTA (only shown to guests) â”€â”€ -->
    <?php if (!$isLoggedIn): ?>
    <div class="cta-box mt-5 text-center">
        <h4 class="fw-bold mb-2">Want full access to all resources?</h4>
        <p class="text-muted mb-3">Subscribe to a plan and unlock downloads, tutorials, and more.</p>
        <a href="pricing.php" class="btn btn-warning fw-bold px-4 me-2">View Plans</a>
        <a href="registration.php" class="btn btn-outline-dark px-4">Register Free</a>
    </div>
    <?php endif; ?>

</div>

<!-- â”€â”€ Footer â”€â”€ -->
<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>876JA Digital Resources</h5>
                <p>Online notes, tutorials, and teaching resources for modern classrooms.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <p><a href="about.php">About Us</a></p>
                <p><a href="library.php">Resource Library</a></p>
                <p><a href="pricing.php">Subscription Plans</a></p>
            </div>
            <div class="col-md-4">
                <h5>External Links</h5>
                <p><a href="https://www.facebook.com" target="_blank" rel="noopener">Facebook</a></p>
                <p><a href="https://www.youtube.com" target="_blank" rel="noopener">YouTube</a></p>
                <p><a href="https://www.paypal.com" target="_blank" rel="noopener">PayPal</a></p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// â”€â”€ Live filter logic â”€â”€
const searchInput   = document.getElementById('searchInput');
const filterCourse  = document.getElementById('filterCourse');
const filterLevel   = document.getElementById('filterLevel');
const resetBtn      = document.getElementById('resetFilters');
const rows          = document.querySelectorAll('.resource-row');
const noResults     = document.getElementById('noResults');
const countLabel    = document.getElementById('resourceCount');
const catCards      = document.querySelectorAll('#categoryCards .category-card');

function applyFilters() {
    const q      = searchInput.value.toLowerCase().trim();
    const course = filterCourse.value;
    const level  = filterLevel.value;
    let visible  = 0;

    rows.forEach(row => {
        const titleMatch  = !q      || row.dataset.title.includes(q);
        const courseMatch = !course || row.dataset.course === course;
        const levelMatch  = !level  || row.dataset.level  === level;

        if (titleMatch && courseMatch && levelMatch) {
            row.classList.remove('d-none');
            visible++;
        } else {
            row.classList.add('d-none');
        }
    });

    const label = visible === 1 ? '1 resource' : `${visible} resources`;
    countLabel.textContent = `Showing ${label}`;
    noResults.classList.toggle('d-none', visible > 0);
}

// Category card click â†’ set course filter
catCards.forEach(card => {
    card.addEventListener('click', () => {
        const selected = card.dataset.category;
        const isSame   = filterCourse.value === selected;

        catCards.forEach(c => c.classList.remove('active-filter'));
        if (isSame) {
            filterCourse.value = '';
        } else {
            filterCourse.value = selected;
            card.classList.add('active-filter');
        }
        applyFilters();
        document.getElementById('resourceTableBody').closest('.card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

// Sync active card highlight when dropdown changes
filterCourse.addEventListener('change', () => {
    catCards.forEach(c => {
        c.classList.toggle('active-filter', c.dataset.category === filterCourse.value);
    });
    applyFilters();
});

searchInput.addEventListener('input', applyFilters);
filterLevel.addEventListener('change', applyFilters);

resetBtn.addEventListener('click', () => {
    searchInput.value  = '';
    filterCourse.value = '';
    filterLevel.value  = '';
    catCards.forEach(c => c.classList.remove('active-filter'));
    applyFilters();
});
</script>
</body>
</html>
