/**
 * CardPlanet Theme Main JavaScript
 */

(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        initializeCardPlanet();
    });
    
    // Initialize all components
    function initializeCardPlanet() {
        initNavigation();
        initSmoothScrolling();
        initAnimations();
        initShowcaseGallery();
        initContactForm();
    }
    
    // Navigation functionality
    function initNavigation() {
        const navbar = $('#navbar');
        const mobileToggle = $('.mobile-menu-toggle');
        const navLinks = $('.nav-links');
        const navOverlay = $('.nav-overlay');
        
        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                navbar.addClass('scrolled');
            } else {
                navbar.removeClass('scrolled');
            }
        });
        
        // Mobile menu toggle
        mobileToggle.click(function() {
            $(this).toggleClass('active');
            navLinks.toggleClass('active');
            navOverlay.toggleClass('active');
            $('body').toggleClass('nav-open');
        });
        
        // Close mobile menu when overlay is clicked
        navOverlay.click(function() {
            mobileToggle.removeClass('active');
            navLinks.removeClass('active');
            navOverlay.removeClass('active');
            $('body').removeClass('nav-open');
        });
        
        // Close mobile menu when link is clicked
        navLinks.find('a').click(function() {
            if (window.innerWidth <= 768) {
                mobileToggle.removeClass('active');
                navLinks.removeClass('active');
                navOverlay.removeClass('active');
                $('body').removeClass('nav-open');
            }
        });
        
        // Smooth scroll for anchor links
        $('a[href^="#"]').not('[href="#"]').click(function(e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });
    }
    
    // Smooth scrolling functionality
    function initSmoothScrolling() {
        // Add smooth scrolling to all internal links
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
                && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000, function() {
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) {
                            return false;
                        } else {
                            $target.attr('tabindex','-1');
                            $target.focus();
                        }
                    });
                }
            }
        });
    }
    
    // Animation functionality with Intersection Observer
    function initAnimations() {
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);
            
            // Observe elements that should animate in
            $('.fade-in, .scale-in, .feature-row, .capability-item').each(function() {
                observer.observe(this);
            });
        }
    }
    
    // Showcase gallery functionality
    function initShowcaseGallery() {
        const track = $('.showcase-track');
        if (!track.length) return;
        
        // Clone items for infinite scroll effect
        const items = track.children().clone();
        track.append(items);
        
        // Pause animation on hover
        track.hover(
            function() { $(this).addClass('paused'); },
            function() { $(this).removeClass('paused'); }
        );
        
        // Lightbox functionality for showcase items
        $('.showcase-item').click(function() {
            const title = $(this).data('title') || $(this).find('.showcase-item-title').text();
            const style = $(this).data('style') || $(this).find('.showcase-item-style').text();
            const image = $(this).find('img').attr('src');
            
            if (image) {
                openLightbox(image, title, style);
            }
        });
    }
    
    // Contact form functionality
    function initContactForm() {
        $('.contact-form').submit(function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('.submit-btn, input[type="submit"]');
            const originalText = submitBtn.text() || submitBtn.val();
            
            // Show loading state
            if (submitBtn.is('input')) {
                submitBtn.val('Sending...');
            } else {
                submitBtn.text('Sending...');
            }
            submitBtn.prop('disabled', true);
            
            // Here you would normally send the form via AJAX
            // For now, we'll simulate a successful submission
            setTimeout(function() {
                showNotification('Message sent successfully!', 'success');
                form[0].reset();
                if (submitBtn.is('input')) {
                    submitBtn.val(originalText);
                } else {
                    submitBtn.text(originalText);
                }
                submitBtn.prop('disabled', false);
            }, 2000);
        });
    }
    
    // Lightbox functionality
    function openLightbox(imageSrc, title, style) {
        const lightbox = $(`
            <div class="lightbox-overlay">
                <div class="lightbox-content">
                    <button class="lightbox-close" aria-label="Close lightbox">&times;</button>
                    <img src="${imageSrc}" alt="${title}">
                    <div class="lightbox-info">
                        <h3>${title}</h3>
                        <p>${style}</p>
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(lightbox);
        lightbox.fadeIn(300);
        
        // Close lightbox
        lightbox.click(function(e) {
            if (e.target === this || $(e.target).hasClass('lightbox-close')) {
                lightbox.fadeOut(300, function() {
                    lightbox.remove();
                });
            }
        });
        
        // ESC key to close
        $(document).keyup(function(e) {
            if (e.keyCode === 27) {
                lightbox.fadeOut(300, function() {
                    lightbox.remove();
                });
                $(document).off('keyup'); // Remove this specific keyup handler
            }
        });
    }
    
    // Notification system
    function showNotification(message, type = 'info') {
        const notification = $(`
            <div class="notification notification--${type}">
                <div class="notification-content">
                    <span class="notification-message">${message}</span>
                    <button class="notification-close" aria-label="Close notification">&times;</button>
                </div>
            </div>
        `);
        
        // Add notification styles if not already present
        if (!$('#notification-styles').length) {
            $('head').append(`
                <style id="notification-styles">
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 10000;
                    max-width: 400px;
                    background: var(--clean-white);
                    border-radius: var(--border-radius-md);
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    transform: translateX(100%);
                    opacity: 0;
                    transition: all 0.3s ease;
                }
                .notification.show {
                    transform: translateX(0);
                    opacity: 1;
                }
                .notification--success {
                    border-left: 4px solid var(--success-green);
                }
                .notification--error {
                    border-left: 4px solid var(--danger-red);
                }
                .notification--info {
                    border-left: 4px solid var(--soft-gold);
                }
                .notification-content {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 16px 20px;
                }
                .notification-message {
                    font-size: var(--font-size-sm);
                    color: var(--text-primary);
                }
                .notification-close {
                    background: none;
                    border: none;
                    font-size: 18px;
                    color: var(--text-light);
                    cursor: pointer;
                    padding: 0;
                    margin-left: 12px;
                }
                </style>
            `);
        }
        
        $('body').append(notification);
        
        // Show notification
        setTimeout(() => notification.addClass('show'), 100);
        
        // Auto hide
        setTimeout(function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 5000);
        
        // Manual close
        notification.find('.notification-close').click(function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        });
    }
    
    // Card hover effects
    $('.style-card, .showcase-item').hover(
        function() {
            $(this).siblings().addClass('dimmed');
        },
        function() {
            $(this).siblings().removeClass('dimmed');
        }
    );
    
    // Performance optimization: Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    // Handle WordPress admin bar
    if ($('#wpadminbar').length) {
        $('.navbar').css('top', '32px');
        $('html').css('margin-top', '0');
    }
    
})(jQuery);