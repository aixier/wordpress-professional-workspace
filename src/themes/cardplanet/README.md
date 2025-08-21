# CardPlanet WordPress Theme

AI-Powered Creative Card Design Platform - Custom WordPress theme based on the original CardPlanet.me design.

## Overview

This theme replicates the CardPlanet website design and functionality in WordPress, maintaining the original warm minimalist aesthetic while adding powerful content management capabilities.

## Features

- **Faithful Design Recreation**: Preserves the original CardPlanet warm minimalist future aesthetic
- **Advanced Custom Fields**: Full integration for easy content management
- **Responsive Design**: Mobile-first approach with perfect adaptation across all devices
- **Performance Optimized**: Clean code, optimized assets, and modern web standards
- **SEO Ready**: Built-in optimization for search engines
- **Accessibility Compliant**: WCAG 2.1 guidelines adherence

## Design System

### Color Palette
- **Base Colors**: Pure whites and silver tones
- **Accent Colors**: Warm gold (#FFD700), soft gold (#f4d03f)
- **Secondary**: Micro blue, soft green, pearl glow
- **Typography**: Primary (#1a1a1a), secondary (#4a4a4a), light (#888888)

### Typography
- **Font Family**: Inter (300, 400, 500, 600)
- **Scale**: Responsive typography system
- **Line Heights**: Optimized for readability

### Spacing System
- **Consistent Scale**: 0.5rem to 8rem
- **Responsive**: Adapts to screen size
- **Component-based**: Consistent across all elements

## File Structure

```
cardplanet-theme/
├── assets/
│   ├── css/
│   │   ├── utilities/
│   │   │   ├── _variables.css    # Design system variables
│   │   │   └── _base.css         # Base styles and resets
│   │   ├── components/
│   │   │   ├── _navigation.css   # Navigation component
│   │   │   ├── _hero.css         # Hero section
│   │   │   └── ...               # Other components
│   │   └── main.css              # Main stylesheet
│   ├── js/
│   │   └── main.js               # Main JavaScript file
│   └── images/                   # Theme images
├── inc/
│   ├── theme-setup.php           # Theme setup functions
│   ├── enqueue-scripts.php       # Scripts and styles enqueue
│   ├── custom-fields.php         # ACF field configurations
│   └── custom-functions.php      # Helper functions
├── template-parts/
│   ├── hero-section.php          # Hero section template
│   └── ...                       # Other template parts
├── page-templates/
│   └── front-page.php            # Custom front page template
├── functions.php                 # Main functions file
├── style.css                     # Theme info and fallback
├── index.php                     # Main template
├── header.php                    # Header template
├── footer.php                    # Footer template
├── front-page.php                # Front page template
└── page.php                      # Page template
```

## Installation

1. **Upload Theme**: Copy the `cardplanet-theme` folder to `/wp-content/themes/`
2. **Activate Theme**: Go to WordPress Admin → Appearance → Themes → Activate CardPlanet
3. **Install Required Plugins**:
   - Advanced Custom Fields Pro (required for full functionality)
   - Contact Form 7 (for contact forms)
   - Yoast SEO (recommended for SEO)

## Configuration

### Step 1: Basic Setup
1. Go to **Settings → General** and set site title and tagline
2. Go to **Settings → Permalinks** and choose "Post name" structure
3. Upload your logo via **Customizer → Site Identity**

### Step 2: Create Homepage
1. Create a new page titled "Home"
2. Assign the "CardPlanet 首页" template
3. Go to **Settings → Reading** and set this page as your homepage

### Step 3: Configure Content
1. Edit your homepage
2. Fill in the ACF fields:
   - Hero Section: Title, subtitle, CTA text and link
   - Showcase Gallery: Add showcase items with images
   - Features: Add feature descriptions and media
   - Capabilities: Add capability items with icons

### Step 4: Navigation
1. Go to **Appearance → Menus**
2. Create a menu and assign it to "Primary Menu" location
3. Add menu items for sections like Features, Pricing, etc.

## Custom Fields Guide

### Hero Section
- **Hero Title**: Main headline (supports HTML)
- **Hero Subtitle**: Descriptive text below title
- **CTA Button Text**: Call-to-action button text
- **CTA Button Link**: Button destination URL

### Showcase Gallery
- **Gallery Title**: Section title
- **Gallery Subtitle**: Section description
- **Showcase Items**: Repeater field with:
  - Title: Item name
  - Style: Design style from dropdown
  - Image: Preview image
  - Link: Link to detail page

### Features Section
- **Features List**: Repeater field with:
  - Title: Feature name
  - Description: Feature details (WYSIWYG)
  - Media: Video, image, or gallery
  - Layout: Content position (left/right)

### Capabilities Section
- **Section Title**: Main section title
- **Capabilities List**: Repeater field with:
  - Icon: Font Awesome class name
  - Title: Capability name
  - Description: Capability details

## Customization

### Adding New Sections
1. Create template part in `template-parts/`
2. Add corresponding CSS in `assets/css/components/`
3. Include in front page template
4. Add ACF fields if needed

### Styling Changes
1. Modify CSS variables in `assets/css/utilities/_variables.css`
2. Update component styles in `assets/css/components/`
3. Add custom styles to `assets/css/main.css`

### Adding Functionality
1. Add functions to `inc/custom-functions.php`
2. Update JavaScript in `assets/js/main.js`
3. Create new template parts as needed

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- IE 11+ (limited support)

## Performance

- **Optimized CSS**: Minimal, component-based architecture
- **Efficient JavaScript**: Modern ES6+ with graceful degradation
- **Image Optimization**: Lazy loading and responsive images
- **Font Loading**: Optimized Google Fonts with display swap

## Development

### Prerequisites
- WordPress 5.0+
- PHP 7.4+
- Advanced Custom Fields Pro

### Development Workflow
1. Make changes to CSS/JS files
2. Test on local WordPress installation
3. Use browser dev tools for debugging
4. Test responsive design on multiple devices

## Migration from Original

This theme maintains 100% visual fidelity with the original CardPlanet.me website while adding:
- WordPress content management
- Easy customization through ACF
- Better SEO capabilities
- Enhanced accessibility
- Improved performance

## Support

For theme support and customization:
1. Check the comprehensive migration documentation
2. Review ACF field configurations
3. Test with sample content
4. Use browser developer tools for debugging

## Changelog

### Version 1.0.0
- Initial release
- Complete CardPlanet design recreation
- ACF integration for content management
- Responsive design implementation
- Basic WordPress functionality

## License

This theme is created specifically for CardPlanet migration and follows WordPress theme development standards.