/**
 * Apple Website Theme - Interactive Enhancements
 * Replicates Apple's smooth animations and interactions
 */

(function() {
    'use strict';

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        setupSmoothScrolling();
        setupNavigationEffects();
        setupProductCardEnhancements();
        setupParallaxEffects();
        setupLoadingAnimations();
        setupAccessibility();
    }

    /**
     * Smooth scrolling for anchor links
     */
    function setupSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const headerOffset = 44; // Height of fixed navigation
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Enhanced navigation effects
     */
    function setupNavigationEffects() {
        const nav = document.querySelector('.globalnav');
        let lastScrollY = window.scrollY;
        let ticking = false;

        function updateNavigation() {
            const scrollY = window.scrollY;
            
            // Background blur effect intensity based on scroll
            if (scrollY > 100) {
                nav.style.background = 'rgba(251, 251, 253, 0.98)';
                nav.style.backdropFilter = 'saturate(180%) blur(25px)';
            } else {
                nav.style.background = 'rgba(251, 251, 253, 0.94)';
                nav.style.backdropFilter = 'saturate(180%) blur(20px)';
            }

            // Hide/show navigation on scroll direction (mobile)
            if (window.innerWidth <= 768) {
                if (scrollY > lastScrollY && scrollY > 100) {
                    nav.style.transform = 'translateY(-100%)';
                } else {
                    nav.style.transform = 'translateY(0)';
                }
            }

            lastScrollY = scrollY;
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateNavigation);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick);

        // Navigation link hover effects
        document.querySelectorAll('.globalnav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });

            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    /**
     * Product card hover enhancements
     */
    function setupProductCardEnhancements() {
        document.querySelectorAll('.product-card').forEach(card => {
            const button = card.querySelector('.button');
            
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
                this.style.boxShadow = '0 20px 60px rgba(0, 0, 0, 0.2)';
                
                // Animate the button
                if (button) {
                    button.style.transform = 'scale(1.05)';
                }
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '';
                
                if (button) {
                    button.style.transform = 'scale(1)';
                }
            });

            // Add click ripple effect
            card.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    left: ${x}px;
                    top: ${y}px;
                    width: ${size}px;
                    height: ${size}px;
                    pointer-events: none;
                `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Subtle parallax effects for hero sections
     */
    function setupParallaxEffects() {
        const heroes = document.querySelectorAll('.unit-wrapper');
        let ticking = false;

        function updateParallax() {
            const scrolled = window.pageYOffset;
            
            heroes.forEach((hero, index) => {
                const rate = scrolled * -0.3;
                const heroRect = hero.getBoundingClientRect();
                
                // Only apply parallax when hero is in viewport
                if (heroRect.bottom >= 0 && heroRect.top <= window.innerHeight) {
                    hero.style.transform = `translateY(${rate}px)`;
                }
            });

            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }

        // Only enable parallax on non-mobile devices
        if (window.innerWidth > 768) {
            window.addEventListener('scroll', requestTick);
        }
    }

    /**
     * Loading animations for product images
     */
    function setupLoadingAnimations() {
        const productImages = document.querySelectorAll('.product-image');
        
        productImages.forEach((img, index) => {
            img.setAttribute('data-loading', 'true');
            
            // Stagger the loading animation
            setTimeout(() => {
                img.removeAttribute('data-loading');
                img.style.animation = 'fadeInUp 0.6s ease forwards';
            }, 100 + (index * 150));
        });

        // Add fadeInUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Accessibility enhancements
     */
    function setupAccessibility() {
        // Focus management for keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });

        // Reduce motion for users who prefer it
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.querySelectorAll('*').forEach(element => {
                element.style.animation = 'none';
                element.style.transition = 'none';
            });
        }

        // High contrast mode adjustments
        if (window.matchMedia('(prefers-contrast: high)').matches) {
            document.body.classList.add('high-contrast');
        }
    }

    /**
     * Button enhancements
     */
    function setupButtonEnhancements() {
        document.querySelectorAll('.button').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });

            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(0) scale(0.98)';
            });

            button.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });
        });
    }

    // Initialize button enhancements
    setupButtonEnhancements();

    /**
     * Image lazy loading simulation
     */
    function setupImageLazyLoading() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '1';
                    img.style.transform = 'scale(1)';
                    observer.unobserve(img);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.product-image').forEach(img => {
            img.style.opacity = '0';
            img.style.transform = 'scale(0.8)';
            img.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(img);
        });
    }

    // Initialize lazy loading
    setupImageLazyLoading();

})();