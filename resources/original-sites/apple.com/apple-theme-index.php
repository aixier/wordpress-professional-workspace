<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class('page-home'); ?>>

    <!-- Global Navigation -->
    <nav id="globalnav" class="globalnav" data-analytics-region="global nav">
        <div class="globalnav-content">
            <ul class="globalnav-list">
                <li class="globalnav-item globalnav-item-apple">
                    <a href="<?php echo home_url(); ?>" class="globalnav-link globalnav-link-apple" aria-label="Apple">
                        <svg height="44" viewBox="0 0 14 44" width="14" xmlns="http://www.w3.org/2000/svg">
                            <path d="m13.0729 17.6825a3.61 3.61 0 0 0 -1.7248 3.0365 3.5132 3.5132 0 0 0 2.1379 3.2223 8.394 8.394 0 0 1 -1.0948 2.2618c-.6816.9812-1.3943 1.9623-2.4787 1.9623s-1.3633-.63-2.613-.63c-1.2187 0-1.6525.6507-2.644.6507s-1.6834-.9089-2.4787-2.0243a9.7842 9.7842 0 0 1 -1.6628-5.2776c0-3.0984 2.014-4.7405 3.9969-4.7405 1.0535 0 1.9314.6919 2.5924.6919.63 0 1.6112-.7333 2.8092-.7333a3.7579 3.7579 0 0 1 3.1604 1.5802zm-3.7284-2.8918a3.5615 3.5615 0 0 0 .8469-2.22 1.5353 1.5353 0 0 0 -.031-.32 3.5686 3.5686 0 0 0 -2.3445 1.2084 3.4629 3.4629 0 0 0 -.8779 2.1585 1.419 1.419 0 0 0 .031.2892 1.19 1.19 0 0 0 .2169.0207 3.0935 3.0935 0 0 0 2.1586-1.1368z"/>
                        </svg>
                    </a>
                </li>
                <li class="globalnav-item">
                    <a href="#store" class="globalnav-link">Store</a>
                </li>
                <li class="globalnav-item">
                    <a href="#mac" class="globalnav-link">Mac</a>
                </li>
                <li class="globalnav-item">
                    <a href="#ipad" class="globalnav-link">iPad</a>
                </li>
                <li class="globalnav-item">
                    <a href="#iphone" class="globalnav-link">iPhone</a>
                </li>
                <li class="globalnav-item">
                    <a href="#watch" class="globalnav-link">Watch</a>
                </li>
                <li class="globalnav-item">
                    <a href="#vision" class="globalnav-link">Vision</a>
                </li>
                <li class="globalnav-item">
                    <a href="#airpods" class="globalnav-link">AirPods</a>
                </li>
                <li class="globalnav-item">
                    <a href="#tv-home" class="globalnav-link">TV & Home</a>
                </li>
                <li class="globalnav-item">
                    <a href="#entertainment" class="globalnav-link">Entertainment</a>
                </li>
                <li class="globalnav-item">
                    <a href="#accessories" class="globalnav-link">Accessories</a>
                </li>
                <li class="globalnav-item">
                    <a href="#support" class="globalnav-link">Support</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main" role="main">
        
        <!-- Hero Section -->
        <section class="homepage-section collection-module" data-analytics-region="hero">
            <div class="unit-wrapper">
                <div class="unit-copy-wrapper">
                    <div class="split-wrapper-top">
                        <h1 class="headline">
                            Discover the innovative world of Apple
                        </h1>
                        <h2 class="subhead">
                            Shop everything iPhone, iPad, Apple Watch, Mac, and Apple TV
                        </h2>
                        <div class="button-group">
                            <a href="#products" class="button">Explore Products</a>
                            <a href="#learn-more" class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="products" class="content-section">
            <h2 class="section-headline">Our Latest Products</h2>
            <p class="section-subhead">Experience the future of technology with our innovative lineup</p>
            
            <div class="product-grid">
                <div class="product-card">
                    <h3 class="product-title">iPhone 15 Pro</h3>
                    <p class="product-description">The most advanced iPhone yet, with titanium design and Action Button.</p>
                    <a href="#iphone" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">MacBook Air</h3>
                    <p class="product-description">Supercharged by M3 chip. Incredibly thin and light design.</p>
                    <a href="#mac" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">Apple Watch Series 9</h3>
                    <p class="product-description">Your essential companion for healthy living and staying connected.</p>
                    <a href="#watch" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">iPad Pro</h3>
                    <p class="product-description">Unbelievably thin and light. Incredibly powerful with M4 chip.</p>
                    <a href="#ipad" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">Apple Vision Pro</h3>
                    <p class="product-description">Welcome to spatial computing. The era of vision pro begins.</p>
                    <a href="#vision" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">AirPods Pro</h3>
                    <p class="product-description">Adaptive Audio. Conversation Awareness. Personalized Volume.</p>
                    <a href="#airpods" class="button">Learn More</a>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="content-section">
            <h2 class="section-headline">Apple Services</h2>
            <p class="section-subhead">Get the most out of your Apple devices with our services</p>
            
            <div class="product-grid">
                <div class="product-card">
                    <h3 class="product-title">iCloud+</h3>
                    <p class="product-description">Keep your photos, files, and more secure and up to date across all your devices.</p>
                    <a href="#icloud" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">Apple Music</h3>
                    <p class="product-description">Over 100 million songs. Spatial Audio. Lossless quality.</p>
                    <a href="#music" class="button">Learn More</a>
                </div>
                
                <div class="product-card">
                    <h3 class="product-title">Apple TV+</h3>
                    <p class="product-description">Award-winning series and films from the world's most creative storytellers.</p>
                    <a href="#tv" class="button">Learn More</a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#privacy" class="footer-link">Privacy Policy</a>
                <a href="#terms" class="footer-link">Terms of Use</a>
                <a href="#sales" class="footer-link">Sales and Refunds</a>
                <a href="#legal" class="footer-link">Legal</a>
                <a href="#site-map" class="footer-link">Site Map</a>
            </div>
            <p class="copyright">
                Copyright © <?php echo date('Y'); ?> Apple Inc. All rights reserved. 
                🤖 Generated with <a href="https://claude.ai/code" style="color: inherit;">Claude Code</a>
            </p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>