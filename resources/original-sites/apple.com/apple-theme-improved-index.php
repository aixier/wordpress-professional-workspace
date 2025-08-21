<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#000000">
    
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Preload key fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class('page-home apple-design'); ?>>

    <!-- Global Navigation -->
    <nav id="globalnav" class="globalnav" role="navigation" aria-label="Global">
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
                    <a href="#tv-home" class="globalnav-link">TV &amp; Home</a>
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
        
        <!-- Hero Section - iPhone 15 Pro -->
        <section class="homepage-section collection-module" data-analytics-region="hero" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="unit-wrapper">
                <div class="unit-copy-wrapper">
                    <div class="split-wrapper-top">
                        <h1 class="headline">
                            iPhone 15 Pro
                        </h1>
                        <h2 class="subhead">
                            Titanium. So strong. So light. So Pro.
                        </h2>
                        <div class="button-group">
                            <a href="#learn-more" class="button">Learn more</a>
                            <a href="#buy" class="button button-secondary">Buy</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Second Hero - MacBook Air -->
        <section class="homepage-section collection-module" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="unit-wrapper">
                <div class="unit-copy-wrapper">
                    <div class="split-wrapper-top">
                        <h1 class="headline">
                            MacBook Air
                        </h1>
                        <h2 class="subhead">
                            Supercharged by M3
                        </h2>
                        <div class="button-group">
                            <a href="#learn-more" class="button">Learn more</a>
                            <a href="#buy" class="button button-secondary">Buy</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Grid Section -->
        <section class="content-section">
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">
                        📱
                    </div>
                    <h3 class="product-title">iPhone 15</h3>
                    <p class="product-description">New camera. New design. Newphoria.</p>
                    <div class="button-group">
                        <a href="#iphone" class="button">Learn more</a>
                        <a href="#buy" class="button button-secondary">Buy</a>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        ⌚
                    </div>
                    <h3 class="product-title">Apple Watch Series 9</h3>
                    <p class="product-description">Smarter. Brighter. Mightier.</p>
                    <div class="button-group">
                        <a href="#watch" class="button">Learn more</a>
                        <a href="#buy" class="button button-secondary">Buy</a>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        📱
                    </div>
                    <h3 class="product-title">iPad</h3>
                    <p class="product-description">Lovable. Drawable. Magical.</p>
                    <div class="button-group">
                        <a href="#ipad" class="button">Learn more</a>
                        <a href="#buy" class="button button-secondary">Buy</a>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        🥽
                    </div>
                    <h3 class="product-title">Apple Vision Pro</h3>
                    <p class="product-description">Welcome to spatial computing.</p>
                    <div class="button-group">
                        <a href="#vision" class="button">Learn more</a>
                        <a href="#buy" class="button button-secondary">Buy</a>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        🎧
                    </div>
                    <h3 class="product-title">AirPods Pro</h3>
                    <p class="product-description">Adaptive Audio. Now playing.</p>
                    <div class="button-group">
                        <a href="#airpods" class="button">Learn more</a>
                        <a href="#buy" class="button button-secondary">Buy</a>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        📺
                    </div>
                    <h3 class="product-title">Apple TV 4K</h3>
                    <p class="product-description">The Apple experience. Cinematic in every sense.</p>
                    <div class="button-group">
                        <a href="#tv" class="button">Learn more</a>
                        <a href="#buy" class="button button-secondary">Buy</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="content-section" style="background-color: var(--apple-bg-secondary); margin: 0 -24px; padding-left: 24px; padding-right: 24px;">
            <h2 class="section-headline">Explore the lineup.</h2>
            
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        ☁️
                    </div>
                    <h3 class="product-title">iCloud+</h3>
                    <p class="product-description">Keep everything safe, synced, and easy to share.</p>
                    <a href="#icloud" class="button">Learn more</a>
                </div>
                
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                        🎵
                    </div>
                    <h3 class="product-title">Apple Music</h3>
                    <p class="product-description">100 million songs. Three all-new radio stations.</p>
                    <a href="#music" class="button">Try it free</a>
                </div>
                
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                        🎬
                    </div>
                    <h3 class="product-title">Apple TV+</h3>
                    <p class="product-description">Award-winning series and films from Apple TV+.</p>
                    <a href="#tv-plus" class="button">Try it free</a>
                </div>
                
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                        🕹️
                    </div>
                    <h3 class="product-title">Apple Arcade</h3>
                    <p class="product-description">100+ games. No ads. No in-app purchases.</p>
                    <a href="#arcade" class="button">Try it free</a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#privacy" class="footer-link">Privacy Policy</a>
                <a href="#terms" class="footer-link">Terms of Use</a>
                <a href="#sales" class="footer-link">Sales and Refunds</a>
                <a href="#legal" class="footer-link">Legal</a>
                <a href="#site-map" class="footer-link">Site Map</a>
            </div>
            <p class="copyright">
                More ways to shop: <a href="#store">Find an Apple Store</a> or <a href="#retailers">other retailer</a> near you. 
                Or call 1-800-MY-APPLE.<br>
                Copyright © <?php echo date('Y'); ?> Apple Inc. All rights reserved. 
                🤖 Generated with <a href="https://claude.ai/code">Claude Code</a>
            </p>
        </div>
    </footer>

    <!-- JavaScript for enhanced interactions -->
    <script>
    // Remove no-js class and add js class
    document.documentElement.classList.remove('no-js');
    document.documentElement.classList.add('js');
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading animation to product images
    document.querySelectorAll('.product-image').forEach(img => {
        img.setAttribute('data-loading', 'true');
        setTimeout(() => {
            img.removeAttribute('data-loading');
        }, 1000 + Math.random() * 2000);
    });
    
    // Enhanced hover effects for product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Parallax effect for hero sections
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroes = document.querySelectorAll('.unit-wrapper');
        
        heroes.forEach((hero, index) => {
            const rate = scrolled * -0.5;
            hero.style.transform = `translateY(${rate}px)`;
        });
    });
    
    // Navigation background on scroll
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('.globalnav');
        if (window.scrollY > 100) {
            nav.style.background = 'rgba(251, 251, 253, 0.98)';
        } else {
            nav.style.background = 'rgba(251, 251, 253, 0.94)';
        }
    });
    </script>

    <?php wp_footer(); ?>
</body>
</html>