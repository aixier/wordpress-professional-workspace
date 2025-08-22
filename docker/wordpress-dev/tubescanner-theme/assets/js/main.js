/**
 * Main JavaScript file for TubeScanner Theme
 */

(function($) {
    'use strict';

    // DOM ready
    $(document).ready(function() {
        initScrollAnimations();
        initSmoothScroll();
        initMobileMenu();
        initBackToTop();
        initParallax();
    });

    // Scroll animations
    function initScrollAnimations() {
        // Intersection Observer for fade-in animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Add fade-in class and observe elements
            const animateElements = document.querySelectorAll('.feature-card, .testimonial-card, .faq-item');
            animateElements.forEach(function(element) {
                element.classList.add('fade-in-element');
                observer.observe(element);
            });
        }
    }

    // Smooth scrolling for anchor links
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                const headerHeight = $('#masthead').outerHeight() || 0;
                const targetPosition = target.offset().top - headerHeight - 20;
                
                $('html, body').animate({
                    scrollTop: targetPosition
                }, 800, 'easeInOutCubic');
            }
        });
    }

    // Mobile menu functionality
    function initMobileMenu() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                this.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
                
                // Animate hamburger icon
                const icon = this.querySelector('svg');
                if (icon) {
                    icon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    }

    // Back to top button
    function initBackToTop() {
        // Create back to top button
        const backToTop = $('<button/>', {
            id: 'back-to-top',
            class: 'fixed bottom-8 right-8 w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 z-50 flex items-center justify-center',
            html: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>',
            'aria-label': 'Back to top'
        });
        
        $('body').append(backToTop);
        
        // Show/hide based on scroll position
        $(window).scroll(function() {
            const scrollTop = $(window).scrollTop();
            if (scrollTop > 300) {
                backToTop.removeClass('opacity-0 invisible').addClass('opacity-100 visible');
            } else {
                backToTop.removeClass('opacity-100 visible').addClass('opacity-0 invisible');
            }
        });
        
        // Scroll to top functionality
        backToTop.on('click', function() {
            $('html, body').animate({scrollTop: 0}, 600, 'easeInOutCubic');
        });
    }

    // Parallax effect
    function initParallax() {
        const parallaxElements = $('.hero-section, .cta-section');
        
        if (parallaxElements.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            $(window).scroll(function() {
                const scrollTop = $(window).scrollTop();
                
                parallaxElements.each(function() {
                    const $element = $(this);
                    const elementTop = $element.offset().top;
                    const elementHeight = $element.outerHeight();
                    const windowHeight = $(window).height();
                    
                    // Check if element is in viewport
                    if (elementTop < scrollTop + windowHeight && elementTop + elementHeight > scrollTop) {
                        const yPos = (scrollTop - elementTop) * 0.5;
                        $element.css('transform', 'translate3d(0, ' + yPos + 'px, 0)');
                    }
                });
            });
        }
    }

    // CTA button hover effects
    $('.cta-button').hover(
        function() {
            $(this).addClass('transform scale-105');
        },
        function() {
            $(this).removeClass('transform scale-105');
        }
    );

    // Feature cards hover animation
    $('.feature-card').hover(
        function() {
            $(this).find('.feature-icon').addClass('animate-pulse');
        },
        function() {
            $(this).find('.feature-icon').removeClass('animate-pulse');
        }
    );

    // Add easing function for smoother animations
    $.easing.easeInOutCubic = function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

    // Add CSS for fade-in animation
    const style = document.createElement('style');
    style.textContent = `
        .fade-in-element {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .animate-fade-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        @media (prefers-reduced-motion: reduce) {
            .fade-in-element {
                opacity: 1;
                transform: none;
                transition: none;
            }
        }
    `;
    document.head.appendChild(style);

})(jQuery);