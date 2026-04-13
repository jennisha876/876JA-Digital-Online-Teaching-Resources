<?php
/*
FAQ - 876JA Digital Online Teaching Resources
Frequently asked questions grouped by topic 
*/

$pageTitle = '876JA Digital Online Teaching Resources | FAQ';
$activePage = 'faq';

function navActive($page, $activePage)
{
    return $page === $activePage ? ' active' : '';
}

$faqs = [
    'Getting Started' => [
        ['q' => 'What is 876JA Digital Online Teaching Resources?',
         'a' => '876JA Digital is an online platform providing educational notes, tutorials, and digital classroom resources for IT students and teachers. Our materials are organised by course and year level to match your programme of study.'],
        ['q' => 'Do I need an account to use the platform?',
         'a' => 'You need a free account to register, but a paid subscription is required to access and download resources. You can browse the public Resource Catalog without logging in to see what is available.'],
        ['q' => 'How do I create an account?',
         'a' => 'Click <a href="registration.php" class="text-decoration-underline">Register</a> in the navigation menu and fill in your name, email address, and a password. Once submitted, your account is created immediately and you can log in right away.'],
    ],
    'Subscriptions & Payments' => [
        ['q' => 'What subscription plans are available?',
         'a' => 'We offer monthly and annual subscription plans at different price tiers. Visit the <a href="pricing.php" class="text-decoration-underline">Pricing</a> page to compare plans and choose the one that suits you best.'],
        ['q' => 'How do I subscribe?',
         'a' => 'Log in to your account, go to the Pricing page, select a plan, and proceed to the payment page to complete your subscription.'],
        ['q' => 'What payment methods are accepted?',
         'a' => 'We currently accept payments via PayPal. Additional payment methods may be added in the future.'],
        ['q' => 'Can I cancel my subscription?',
         'a' => 'Yes. You can cancel at any time from your account dashboard. Your access will remain active until the end of the current billing period.'],
        ['q' => 'Will I be charged automatically each month?',
         'a' => 'Subscriptions renew automatically at the end of each billing cycle. You will receive an email reminder before any charge is processed.'],
    ],
    'Accessing Resources' => [
        ['q' => 'What types of resources are available?',
         'a' => 'The platform offers lecture notes (PDF and HTML), step-by-step tutorials, case study documents, and reference guides. Resources are grouped by IT course: Programming, Web Development, Databases, Systems Analysis, Networking & Hardware, and Data Structures.'],
        ['q' => 'Can I search or filter resources?',
         'a' => 'Yes. The Resource Catalog has a live search bar and filters by course and year level so you can quickly find what you need.'],
        ['q' => 'Can I download resources to use offline?',
         'a' => 'Subscribers can download available PDF and document resources for offline use. Tutorial pages are browser-based and require an internet connection.'],
        ['q' => 'Are resources organised by year level?',
         'a' => 'Yes. Each resource is tagged by year (Year 1, Year 2, or Year 3) so you can easily find materials that match your current stage of study.'],
    ],
    'Technical Support' => [
        ['q' => 'I forgot my password. What do I do?',
         'a' => 'Click <a href="forgot-password.php" class="text-decoration-underline">Forgot Password</a> on the login page, enter your registered email address, and we will send you a secure reset link.'],
        ['q' => 'I am not receiving emails from the platform.',
         'a' => 'Please check your spam or junk mail folder first. If the email is not there, make sure the address you registered with is correct. You can also contact us via the <a href="contact.php" class="text-decoration-underline">Contact Us</a> page for further help.'],
        ['q' => 'The page is not loading correctly. What should I do?',
         'a' => 'Try clearing your browser cache and refreshing the page. If the issue continues, try a different browser or device. If the problem persists, please let us know through the Contact Us page.'],
        ['q' => 'Who do I contact if I have a problem with my account?',
         'a' => 'Use the <a href="contact.php" class="text-decoration-underline">Contact Us</a> form to send us a message and we will respond as soon as possible.'],
    ],
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
        /* â”€â”€ FAQ-specific styles â”€â”€ */
        .faq-section-heading {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9a6d00;
            background: rgba(245,197,66,0.13);
            border: 1px solid rgba(245,197,66,0.22);
            border-radius: 0.5rem;
            display: inline-block;
            padding: 0.3em 0.8em;
            margin-bottom: 1rem;
        }

        .accordion-button {
            font-weight: 600;
            color: var(--brand-dark);
            background: #fff;
            border-radius: 0.9rem !important;
        }

        .accordion-button:not(.collapsed) {
            color: #0a58ca;
            background: rgba(13,110,253,0.05);
            box-shadow: none;
        }

        .accordion-button::after {
            filter: none;
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.2rem rgba(245,197,66,0.25);
        }

        .accordion-item {
            border: 1px solid rgba(15,23,42,0.08);
            border-radius: 0.9rem !important;
            overflow: hidden;
            margin-bottom: 0.6rem;
            background: #fff;
            box-shadow: 0 0.35rem 1rem rgba(31,41,55,0.05);
            transition: box-shadow 0.2s ease;
        }

        .accordion-item:hover {
            box-shadow: 0 0.5rem 1.4rem rgba(31,41,55,0.09);
        }

        .accordion-body {
            color: rgba(36,50,71,0.85);
            line-height: 1.75;
            padding-top: 0.25rem;
        }

        .faq-search-wrap {
            max-width: 38rem;
            margin: 0 auto 3rem;
        }

        .faq-group {
            margin-bottom: 2.75rem;
        }

        /* Highlight matched search text */
        mark {
            background: rgba(245,197,66,0.35);
            padding: 0;
            border-radius: 0.2rem;
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
                <li class="nav-item"><a class="nav-link<?php echo navActive('home',    $activePage); ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('about',   $activePage); ?>" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link"                                                  href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('faq',     $activePage); ?>" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-login-btn<?php echo navActive('login', $activePage); ?>" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- â”€â”€ Page Banner â”€â”€ -->
<section class="page-banner">
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <p class="mb-0 mt-2 opacity-75">Find answers to common questions about the platform, subscriptions, and resources.</p>
    </div>
</section>

<div class="container pb-5">

    <!-- â”€â”€ Search â”€â”€ -->
    <div class="faq-search-wrap">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="faqSearch" class="form-control border-start-0 ps-0"
                   placeholder="Search questionsâ€¦" autocomplete="off">
            <button class="btn btn-outline-secondary" id="clearSearch" style="display:none;" title="Clear">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <p id="searchStatus" class="text-muted small mt-2 text-center" style="min-height:1.2em;"></p>
    </div>

    <!-- â”€â”€ FAQ Groups â”€â”€ -->
    <?php
    $groupIndex = 0;
    foreach ($faqs as $groupName => $items):
        $groupSlug = 'group-' . $groupIndex++;
    ?>
    <div class="faq-group" id="<?php echo $groupSlug; ?>">
        <span class="faq-section-heading">
            <?php echo htmlspecialchars($groupName); ?>
        </span>
        <div class="accordion" id="accordion-<?php echo $groupSlug; ?>">
            <?php foreach ($items as $i => $item):
                $itemId = $groupSlug . '-item-' . $i;
            ?>
            <div class="accordion-item faq-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed faq-question" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?php echo $itemId; ?>"
                            aria-expanded="false"
                            aria-controls="<?php echo $itemId; ?>">
                        <?php echo htmlspecialchars($item['q']); ?>
                    </button>
                </h2>
                <div id="<?php echo $itemId; ?>" class="accordion-collapse collapse"
                     data-bs-parent="#accordion-<?php echo $groupSlug; ?>">
                    <div class="accordion-body faq-answer">
                        <?php echo $item['a']; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- No results -->
    <div id="noFaqResults" class="text-center py-5 d-none">
        <i class="bi bi-question-circle fs-1 text-muted opacity-50"></i>
        <p class="mt-3 text-muted">No questions matched your search. Try different keywords.</p>
        <a href="contact.php" class="btn btn-warning fw-semibold mt-1">Ask Us Directly</a>
    </div>

    <!-- â”€â”€ Still need help CTA â”€â”€ -->
    <div class="cta-box mt-4 text-center" id="ctaBox">
        <h5 class="fw-bold mb-1">Still have a question?</h5>
        <p class="text-muted mb-3">Our support team is happy to help. Send us a message and we'll get back to you.</p>
        <a href="contact.php" class="btn btn-warning fw-bold px-4 me-2">Contact Us</a>
        <a href="registration.php" class="btn btn-outline-dark px-4">Create Account</a>
    </div>

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
// â”€â”€ FAQ live search â”€â”€
const searchInput  = document.getElementById('faqSearch');
const clearBtn     = document.getElementById('clearSearch');
const statusEl     = document.getElementById('searchStatus');
const noResults    = document.getElementById('noFaqResults');
const ctaBox       = document.getElementById('ctaBox');
const groups       = document.querySelectorAll('.faq-group');

function escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function highlightText(text, term) {
    if (!term) return text;
    const re = new RegExp('(' + escapeRegex(term) + ')', 'gi');
    return text.replace(re, '<mark>$1</mark>');
}

function applySearch() {
    const q = searchInput.value.trim();
    clearBtn.style.display = q ? '' : 'none';

    if (!q) {
        // Reset everything
        groups.forEach(g => {
            g.style.display = '';
            g.querySelectorAll('.faq-item').forEach(item => {
                item.style.display = '';
                // Restore original text
                const btn = item.querySelector('.faq-question');
                const body = item.querySelector('.faq-answer');
                btn.textContent  = btn.getAttribute('data-original') || btn.textContent;
                body.innerHTML   = body.getAttribute('data-original') || body.innerHTML;
            });
        });
        noResults.classList.add('d-none');
        ctaBox.classList.remove('d-none');
        statusEl.textContent = '';
        return;
    }

    const lq = q.toLowerCase();
    let total = 0;

    groups.forEach(group => {
        let groupVisible = 0;
        group.querySelectorAll('.faq-item').forEach(item => {
            const btn  = item.querySelector('.faq-question');
            const body = item.querySelector('.faq-answer');

            // Store originals once
            if (!btn.getAttribute('data-original'))  btn.setAttribute('data-original',  btn.textContent);
            if (!body.getAttribute('data-original'))  body.setAttribute('data-original', body.innerHTML);

            const qText = btn.getAttribute('data-original').toLowerCase();
            const aText = body.getAttribute('data-original').toLowerCase().replace(/<[^>]+>/g, '');

            if (qText.includes(lq) || aText.includes(lq)) {
                item.style.display = '';
                btn.innerHTML  = highlightText(btn.getAttribute('data-original'), q);
                body.innerHTML = highlightText(body.getAttribute('data-original'), q);

                // Auto-expand matched item
                const collapseEl = item.querySelector('.accordion-collapse');
                if (collapseEl && !collapseEl.classList.contains('show')) {
                    new bootstrap.Collapse(collapseEl, { toggle: false }).show();
                }
                groupVisible++;
                total++;
            } else {
                item.style.display = 'none';
            }
        });
        group.style.display = groupVisible > 0 ? '' : 'none';
    });

    const label = total === 1 ? '1 result' : `${total} results`;
    statusEl.textContent = total > 0 ? `Showing ${label} for "${q}"` : '';
    noResults.classList.toggle('d-none', total > 0);
    ctaBox.classList.toggle('d-none', total === 0);
}

searchInput.addEventListener('input', applySearch);
clearBtn.addEventListener('click', () => {
    searchInput.value = '';
    applySearch();
    searchInput.focus();
});
</script>
</body>
</html>
