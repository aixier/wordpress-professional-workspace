# WordPress Migration Standard Operating Procedure (SOP)

> **Complete workflow for migrating static websites to WordPress using the CardPlanet development environment**

## 📋 Overview

This SOP provides a standardized, step-by-step process for converting static HTML websites into fully functional WordPress themes using modern development practices and automated tools.

### Migration Objectives

- ✅ **Preserve all content, styling, and functionality** from the original website
- ✅ **Maintain responsive design** and user experience consistency  
- ✅ **Create maintainable WordPress theme** structure following best practices
- ✅ **Ensure seamless deployment** with zero downtime
- ✅ **Document the process** for future reference and team collaboration

---

## 🎯 Phase 1: Project Setup & Analysis

### 1.1 Environment Initialization

```bash
# Initialize CardPlanet workspace
make setup

# Verify environment is running
curl -I http://localhost:8080
# Expected: HTTP/1.1 200 OK
```

### 1.2 Original Website Analysis

**📋 Analysis Checklist:**

```bash
# Create analysis directory
mkdir -p resources/original-sites/[CLIENT_NAME]
cd resources/original-sites/[CLIENT_NAME]

# Copy original website files
cp -r /path/to/original-site/* .

# Analyze file structure
find . -name "*.html" | wc -l    # Count HTML files
find . -name "*.css" | wc -l     # Count CSS files  
find . -name "*.js" | wc -l      # Count JS files
find . -type f -name "*.jpg" -o -name "*.png" -o -name "*.svg" | wc -l  # Count images
```

**🔍 Content Analysis:**

- [ ] **Navigation Structure**: Identify menu items and hierarchy
- [ ] **Page Templates**: Categorize different page layouts
- [ ] **Interactive Elements**: Forms, sliders, animations
- [ ] **Media Usage**: Images, videos, fonts, icons
- [ ] **Third-party Dependencies**: External libraries, APIs
- [ ] **SEO Elements**: Meta tags, structured data, sitemaps

**🎨 Design System Extraction:**

```bash
# Extract CSS variables and design tokens
grep -r ":root\|--.*:" . > design-tokens.txt
grep -r "color:\|background-color:" . | head -20 > color-palette.txt

# Analyze typography
grep -r "font-family\|font-size\|font-weight:" . | head -15 > typography.txt

# Document breakpoints
grep -r "@media" . | grep -o "max-width:[^)]*\|min-width:[^)]*" | sort -u > breakpoints.txt
```

**📝 Create Migration Plan:**

```markdown
# [CLIENT_NAME] Migration Plan

## Project Details
- **Client**: [CLIENT_NAME]
- **Original URL**: [URL]
- **Migration Date**: [DATE]
- **Developer**: [NAME]

## Site Analysis Summary
- **Pages**: [NUMBER] HTML pages
- **Unique Layouts**: [NUMBER] different templates
- **Key Features**: [LIST]
- **Technical Dependencies**: [LIST]

## Migration Strategy
1. [STRATEGY_POINT_1]
2. [STRATEGY_POINT_2]
3. [STRATEGY_POINT_3]

## Timeline
- Analysis: [DATE]
- Development: [DATE_RANGE]  
- Testing: [DATE_RANGE]
- Deployment: [DATE]
```

---

## 🏗️ Phase 2: WordPress Environment Setup

### 2.1 Create Theme Structure

```bash
# Generate new theme using our template
cd src/themes
mkdir [CLIENT_NAME]-theme
cd [CLIENT_NAME]-theme

# Create standard WordPress theme structure
mkdir -p {assets/{css,js,images,fonts},inc,template-parts}
touch {style.css,functions.php,index.php,header.php,footer.php}
```

### 2.2 Theme Header Configuration

**style.css:**
```css
/*
Theme Name: [CLIENT_NAME] Theme
Description: Custom WordPress theme migrated from [ORIGINAL_URL]
Author: [DEVELOPER_NAME]
Version: 1.0.0
Text Domain: [client-name]
WordPress Version: 6.8+
PHP Version: 7.4+
*/

/* Theme styles will be imported from assets/css/ */
@import url('./assets/css/main.css');
```

### 2.3 Basic Theme Files

**functions.php:**
```php
<?php
/**
 * [CLIENT_NAME] Theme Functions
 * 
 * @package ClientTheme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup and configuration
 */
function client_theme_setup() {
    // Theme support features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));
    add_theme_support('custom-logo');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Navigation', '[client-name]'),
        'footer'  => __('Footer Navigation', '[client-name]')
    ));
}
add_action('after_setup_theme', 'client_theme_setup');

/**
 * Enqueue scripts and styles
 */
function client_theme_scripts() {
    // Theme stylesheet
    wp_enqueue_style(
        '[client-name]-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );
    
    // Theme JavaScript
    wp_enqueue_script(
        '[client-name]-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );
    
    // Remove WordPress default styles that might conflict
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'client_theme_scripts');

/**
 * Custom functions and helpers
 */
require get_template_directory() . '/inc/custom-functions.php';
```

### 2.4 Minimal Working Index

**index.php:**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Temporary migration status -->
    <div style="max-width: 800px; margin: 50px auto; padding: 40px; text-align: center; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h1>🚀 [CLIENT_NAME] WordPress Theme</h1>
        <p><strong>Migration Status:</strong> Theme structure created, ready for content migration</p>
        <p><strong>WordPress Version:</strong> <?php echo get_bloginfo('version'); ?></p>
        <p><strong>Theme Version:</strong> <?php echo wp_get_theme()->get('Version'); ?></p>
        <hr style="margin: 30px 0; border: 1px solid #eee;">
        <p><em>Original content migration in progress...</em></p>
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>
```

### 2.5 Deploy and Test Base Theme

```bash
# Build and deploy theme
make build

# Activate theme via WP-CLI
docker exec cardplanet_wp wp theme activate [client-name]-theme --allow-root

# Verify theme is active
curl -s http://localhost:8080 | grep -i "[CLIENT_NAME]"
```

---

## 🎨 Phase 3: Content Migration Implementation

### 3.1 Asset Migration

```bash
# Copy all static assets to theme
cd resources/original-sites/[CLIENT_NAME]

# Images and media
cp -r images/* ../../../src/themes/[CLIENT_NAME]-theme/assets/images/
cp -r *.jpg *.png *.svg ../../../src/themes/[CLIENT_NAME]-theme/assets/images/ 2>/dev/null || true

# Fonts
cp -r fonts/* ../../../src/themes/[CLIENT_NAME]-theme/assets/fonts/ 2>/dev/null || true

# JavaScript files
cp -r js/* ../../../src/themes/[CLIENT_NAME]-theme/assets/js/ 2>/dev/null || true
cp *.js ../../../src/themes/[CLIENT_NAME]-theme/assets/js/ 2>/dev/null || true

# CSS files (for analysis and integration)
cp -r css/* ../../../src/themes/[CLIENT_NAME]-theme/assets/css/original/ 2>/dev/null || true
cp *.css ../../../src/themes/[CLIENT_NAME]-theme/assets/css/original/ 2>/dev/null || true
```

### 3.2 CSS Integration

**Main CSS Structure:**
```bash
cd src/themes/[CLIENT_NAME]-theme/assets/css

# Create organized CSS structure
mkdir -p {base,components,layout,utilities}
touch {main.css,base/_reset.css,base/_typography.css,base/_variables.css}
```

**assets/css/main.css:**
```css
/**
 * [CLIENT_NAME] Theme Styles
 * Organized using ITCSS (Inverted Triangle CSS) methodology
 */

/* 1. Settings - Variables, config switches */
@import 'base/variables.css';

/* 2. Generic - Ground-zero styles (normalize.css, reset, box-sizing) */
@import 'base/reset.css';

/* 3. Base - Unclassed HTML elements (type selectors) */
@import 'base/typography.css';

/* 4. Objects - Cosmetic-free design patterns */
@import 'layout/grid.css';
@import 'layout/containers.css';

/* 5. Components - Designed components, chunks of UI */
@import 'components/navigation.css';
@import 'components/hero.css';
@import 'components/buttons.css';
@import 'components/forms.css';

/* 6. Utilities - Helpers and overrides */
@import 'utilities/spacing.css';
@import 'utilities/text.css';

/* 7. Original website styles (preserved) */
@import 'original/main.css';
```

### 3.3 HTML Content Extraction

**Extract and convert main content:**

```bash
# Create extraction script
cat > scripts/extract-content.sh << 'EOF'
#!/bin/bash
CLIENT_NAME="$1"
ORIGINAL_DIR="resources/original-sites/${CLIENT_NAME}"
THEME_DIR="src/themes/${CLIENT_NAME}-theme"

echo "Extracting content from ${ORIGINAL_DIR}/index.html..."

# Extract navigation
grep -A 20 -B 5 "<nav\|navigation\|menu" "${ORIGINAL_DIR}/index.html" > "${THEME_DIR}/extracted/navigation.html"

# Extract main content
grep -A 100 -B 5 "<main\|<section\|class.*content\|id.*content" "${ORIGINAL_DIR}/index.html" > "${THEME_DIR}/extracted/main-content.html"

# Extract footer
grep -A 20 -B 5 "<footer" "${ORIGINAL_DIR}/index.html" > "${THEME_DIR}/extracted/footer.html"

echo "Content extracted to ${THEME_DIR}/extracted/"
EOF

chmod +x scripts/extract-content.sh
./scripts/extract-content.sh [CLIENT_NAME]
```

### 3.4 WordPress Template Integration

**Update index.php with original design:**

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <!-- Original website meta tags and external resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Add original external CSS/JS here -->
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Navigation (converted from original) -->
    <nav class="main-navigation">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class'     => 'nav-menu',
            'fallback_cb'    => false
        ));
        ?>
    </nav>
    
    <!-- Main content area (preserve original structure) -->
    <main class="site-main">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <!-- Original hero section converted to WordPress -->
                <section class="hero">
                    <div class="container">
                        <h1><?php bloginfo('name'); ?></h1>
                        <p><?php bloginfo('description'); ?></p>
                    </div>
                </section>
                
                <!-- Original content sections -->
                <div class="content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </main>
    
    <!-- Footer (converted from original) -->
    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_class'     => 'footer-menu'
            ));
            ?>
        </div>
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>
```

---

## ✅ Phase 4: Quality Assurance & Testing

### 4.1 Automated Testing

```bash
# Build and deploy latest changes
make build

# Test basic functionality
curl -s http://localhost:8080 | grep -i "<!DOCTYPE html" && echo "✅ HTML structure OK"
curl -s http://localhost:8080/wp-admin | grep -i "wordpress" && echo "✅ Admin accessible"

# Test responsive design
curl -H "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X)" \
     -s http://localhost:8080 | head -20

# Validate CSS and assets
curl -I http://localhost:8080/wp-content/themes/[CLIENT_NAME]-theme/assets/css/main.css
curl -I http://localhost:8080/wp-content/themes/[CLIENT_NAME]-theme/assets/js/main.js
```

### 4.2 Visual Comparison Testing

**Create comparison report:**

```bash
# Screenshot original website (if available online)
# Screenshot new WordPress version

# Create side-by-side comparison
echo "## Visual Comparison Report" > comparison-report.md
echo "" >> comparison-report.md
echo "### Desktop View" >> comparison-report.md
echo "- **Original**: ![Original](screenshots/original-desktop.png)" >> comparison-report.md
echo "- **WordPress**: ![WordPress](screenshots/wordpress-desktop.png)" >> comparison-report.md
echo "" >> comparison-report.md
echo "### Mobile View" >> comparison-report.md
echo "- **Original**: ![Original](screenshots/original-mobile.png)" >> comparison-report.md
echo "- **WordPress**: ![WordPress](screenshots/wordpress-mobile.png)" >> comparison-report.md
```

### 4.3 Functionality Testing Checklist

- [ ] **Navigation**: All menu items work correctly
- [ ] **Responsive Design**: Mobile, tablet, desktop views
- [ ] **Images**: All images load and display properly
- [ ] **Typography**: Fonts, sizes, and spacing match original
- [ ] **Colors**: Color scheme matches original design
- [ ] **Forms**: Contact forms and other forms function
- [ ] **JavaScript**: Interactive elements work as expected
- [ ] **Performance**: Page load times are acceptable
- [ ] **SEO**: Meta tags, structured data preserved
- [ ] **Accessibility**: Basic accessibility standards met

### 4.4 WordPress-Specific Testing

```bash
# Test WordPress admin functionality
docker exec cardplanet_wp wp option get blogname
docker exec cardplanet_wp wp theme list
docker exec cardplanet_wp wp plugin list

# Test content management
docker exec cardplanet_wp wp post create \
    --post_title="Test Post" \
    --post_content="Testing content management" \
    --post_status=publish

# Verify theme customization
docker exec cardplanet_wp wp theme mod set \
    custom_logo "$(docker exec cardplanet_wp wp media import /path/to/logo.png --porcelain)"
```

---

## 📋 Phase 5: Documentation & Deployment

### 5.1 Create Migration Documentation

```bash
# Generate comprehensive documentation
cat > docs/examples/[CLIENT_NAME]-migration-report.md << EOF
# [CLIENT_NAME] WordPress Migration Report

## 🎯 Migration Summary

**Completion Date**: $(date)
**Original Website**: [URL]
**WordPress Site**: http://localhost:8080
**Theme Name**: [CLIENT_NAME] Theme
**Migration Type**: Static HTML to WordPress

## ✅ Migration Achievements

- [x] Complete visual fidelity maintained
- [x] Responsive design preserved  
- [x] All content migrated successfully
- [x] WordPress admin functionality integrated
- [x] Performance optimized
- [x] SEO elements preserved

## 🏗️ Technical Implementation

### Theme Structure
\`\`\`
src/themes/[CLIENT_NAME]-theme/
├── style.css                 # Theme header and main imports
├── functions.php             # WordPress functionality
├── index.php                 # Main template
├── header.php                # Site header
├── footer.php                # Site footer
├── assets/
│   ├── css/                  # Organized stylesheets
│   ├── js/                   # JavaScript files
│   ├── images/               # Image assets
│   └── fonts/                # Typography files
└── inc/                      # Custom functions
\`\`\`

### Key Features Migrated
- Original navigation structure
- Hero section with dynamic content
- Responsive grid layout
- Contact forms (converted to WordPress)
- Image galleries
- Custom styling and animations

## 📊 Performance Metrics

- **Page Load Time**: [TIME]ms
- **Total Size**: [SIZE]KB
- **Images Optimized**: [COUNT]
- **CSS Minified**: Yes
- **JavaScript Optimized**: Yes

## 🔧 Maintenance Instructions

### Content Updates
\`\`\`bash
# Update site content via WordPress admin
# Access: http://localhost:8080/wp-admin

# Or use WP-CLI
docker exec cardplanet_wp wp post list
docker exec cardplanet_wp wp post update ID --post_title="New Title"
\`\`\`

### Theme Customization
\`\`\`bash
# Edit source files
cd src/themes/[CLIENT_NAME]-theme/

# Build and deploy changes
make build

# Test changes
open http://localhost:8080
\`\`\`

### Backup Procedures
\`\`\`bash
# Database backup
docker exec cardplanet_mysql mysqldump -u wordpress -p wordpress > backup.sql

# File backup
tar -czf [CLIENT_NAME]-backup-$(date +%Y%m%d).tar.gz src/themes/[CLIENT_NAME]-theme/
\`\`\`

## 🚀 Next Steps

1. **Content Population**: Add real content via WordPress admin
2. **Plugin Integration**: Install necessary WordPress plugins
3. **Performance Optimization**: Implement caching and optimization
4. **SEO Setup**: Configure SEO plugins and meta data
5. **Security Hardening**: Implement security best practices
6. **Backup Strategy**: Set up automated backups
7. **Monitoring**: Implement uptime and performance monitoring

## 📞 Support Information

- **Documentation**: [PROJECT_DOCS_URL]
- **Theme Files**: \`src/themes/[CLIENT_NAME]-theme/\`
- **Backup Location**: \`resources/backups/\`
- **Development Environment**: CardPlanet WordPress Workspace
EOF
```

### 5.2 Create Handover Package

```bash
# Create client delivery package
mkdir -p delivery/[CLIENT_NAME]/
cp -r src/themes/[CLIENT_NAME]-theme/ delivery/[CLIENT_NAME]/theme/
cp docs/examples/[CLIENT_NAME]-migration-report.md delivery/[CLIENT_NAME]/
cp -r resources/original-sites/[CLIENT_NAME]/ delivery/[CLIENT_NAME]/original/

# Create production deployment files
cp docker/docker-compose.yml delivery/[CLIENT_NAME]/docker-compose-production.yml
cp .env.example delivery/[CLIENT_NAME]/.env.production

# Package everything
cd delivery/
tar -czf [CLIENT_NAME]-wordpress-delivery-$(date +%Y%m%d).tar.gz [CLIENT_NAME]/

echo "✅ Delivery package created: [CLIENT_NAME]-wordpress-delivery-$(date +%Y%m%d).tar.gz"
```

### 5.3 Production Deployment Checklist

- [ ] **Domain Setup**: DNS configured and pointing to server
- [ ] **SSL Certificate**: HTTPS enabled and working
- [ ] **Database**: Production database created and configured
- [ ] **File Permissions**: Correct file permissions set
- [ ] **WordPress Security**: Security plugins installed and configured
- [ ] **Backups**: Automated backup system in place
- [ ] **Monitoring**: Uptime monitoring configured
- [ ] **Performance**: Caching and optimization enabled
- [ ] **Testing**: Full functionality test on production
- [ ] **Documentation**: Client training and documentation provided

---

## 🔧 Troubleshooting Guide

### Common Issues & Solutions

| Issue | Symptoms | Solution |
|-------|----------|----------|
| **CSS not loading** | Styles appear broken | Check file paths in `functions.php`, verify assets copied correctly |
| **Images missing** | Broken image icons | Ensure images copied to `assets/images/`, update image paths in templates |
| **Navigation broken** | Menu not displaying | Create WordPress menus in admin, assign to theme locations |
| **JavaScript errors** | Interactive elements not working | Check browser console, verify JS files enqueued properly |
| **Mobile layout issues** | Responsive design broken | Review original CSS media queries, test viewport meta tag |
| **Performance slow** | Page loads slowly | Optimize images, minify CSS/JS, enable caching |

### Debug Commands

```bash
# Check theme activation status
docker exec cardplanet_wp wp theme status

# Verify assets are loading
curl -I http://localhost:8080/wp-content/themes/[CLIENT_NAME]-theme/assets/css/main.css

# Check for PHP errors
docker logs cardplanet_wp | tail -20

# Test database connection  
docker exec cardplanet_wp wp db check

# Verify WordPress configuration
docker exec cardplanet_wp wp config list
```

### Emergency Rollback Procedure

```bash
# 1. Stop current WordPress instance
docker stop cardplanet_wp

# 2. Restore from backup
cd resources/backups/
tar -xzf [BACKUP_NAME].tar.gz
cp -r backup-content/* ../../src/themes/[CLIENT_NAME]-theme/

# 3. Restart services
make setup

# 4. Verify restoration
curl -s http://localhost:8080 | head -10
```

---

## 📊 Success Metrics

### Migration Quality Standards

1. **Visual Fidelity**: 95%+ match to original design
2. **Functionality**: 100% of original features working
3. **Performance**: Load time within 120% of original
4. **Responsiveness**: Perfect display on all device sizes
5. **SEO Preservation**: All meta data and structure intact
6. **Accessibility**: WCAG 2.1 AA compliance maintained

### Project Timeline Benchmarks

- **Simple Site (1-5 pages)**: 2-3 days
- **Medium Site (5-15 pages)**: 1-2 weeks  
- **Complex Site (15+ pages)**: 2-4 weeks
- **E-commerce Site**: 3-6 weeks (depending on features)

---

## 🚀 Advanced Migration Techniques

### Custom Post Types

For sites with specialized content types:

```php
// Add to functions.php
function register_custom_post_types() {
    register_post_type('portfolio', array(
        'label' => 'Portfolio Items',
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail')
    ));
}
add_action('init', 'register_custom_post_types');
```

### Advanced Custom Fields Integration

```bash
# Install ACF via WP-CLI
docker exec cardplanet_wp wp plugin install advanced-custom-fields --activate

# Create field groups programmatically
# Add field definitions to theme's functions.php
```

### Multi-language Sites

```bash
# For multi-language original sites
# Install WPML or Polylang
docker exec cardplanet_wp wp plugin install polylang --activate

# Configure language settings
# Migrate content for each language
```

---

This SOP ensures consistent, high-quality WordPress migrations while maintaining professional standards and documentation. Each phase builds upon the previous one, creating a reliable workflow that can be repeated across different projects and team members.

**📚 For additional resources and examples, see:**
- [Theme Development Guide](../development/theme-development.md)
- [Deployment Documentation](../deployment/docker.md)  
- [Example Migrations](../examples/)