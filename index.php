<?php include 'includes/header.php'; ?>

<section class="hero-section">
    <div class="container text-center">
        <h1>Teaching Resources Made Simple</h1>
        <p class="mx-auto mt-3">
            876JA Digital Online Teaching Resources gives teachers and subscribers fast access to notes,
            tutorials, worksheets, and classroom support materials across multiple subject areas.
        </p>
        <a href="catalog.php" class="btn btn-light btn-lg mt-3">Browse Resources</a>
        <a href="register.php" class="btn btn-outline-light btn-lg mt-3 ms-2">Create Account</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Why Choose Us</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <h4>Easy Access</h4>
                    <p>Subscribers can access digital teaching materials anytime from one platform.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <h4>Multiple Categories</h4>
                    <p>Resources are arranged by subject so users can find materials quickly.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <h4>Flexible Plans</h4>
                    <p>Users can choose a subscription package that matches their needs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Resource Categories</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card category-card">
                    <img src="images/math.jpg" alt="Mathematics">
                    <div class="card-body">
                        <h5>Mathematics</h5>
                        <p>Lessons, worksheets, examples, and tutorial materials.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card category-card">
                    <img src="images/science.jpg" alt="Science">
                    <div class="card-body">
                        <h5>Science</h5>
                        <p>Digital notes and learning support for general science topics.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card category-card">
                    <img src="images/language.jpg" alt="Language Arts">
                    <div class="card-body">
                        <h5>Language Arts</h5>
                        <p>Reading, writing, and grammar resources for classroom use.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card category-card">
                    <img src="images/social-studies.jpg" alt="Social Studies">
                    <div class="card-body">
                        <h5>Social Studies</h5>
                        <p>Notes, activities, and teaching support materials.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card category-card">
                    <img src="images/it.jpg" alt="Information Technology">
                    <div class="card-body">
                        <h5>Information Technology</h5>
                        <p>Technical resources, tutorials, and classroom content.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card category-card">
                    <img src="images/business.jpg" alt="Business">
                    <div class="card-body">
                        <h5>Business</h5>
                        <p>Teaching resources for business subjects and support lessons.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="cta-box text-center">
            <h2 class="section-title">Search the Resource Library</h2>
            <form class="search-box d-flex" action="catalog.php" method="get">
                <input type="text" name="search" class="form-control me-2" placeholder="Search resources">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Subscription Plans</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card plan-card p-4 text-center">
                    <h4>Basic</h4>
                    <p class="plan-price">$5</p>
                    <p>Access to standard digital teaching materials.</p>
                    <a href="payment.php?plan=basic" class="btn btn-primary">Subscribe</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card plan-card p-4 text-center">
                    <h4>Pro</h4>
                    <p class="plan-price">$10</p>
                    <p>More resources, wider access, and extra downloads.</p>
                    <a href="payment.php?plan=pro" class="btn btn-primary">Subscribe</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card plan-card p-4 text-center">
                    <h4>School License</h4>
                    <p class="plan-price">$25</p>
                    <p>Designed for wider institutional access and support.</p>
                    <a href="payment.php?plan=school" class="btn btn-primary">Subscribe</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
