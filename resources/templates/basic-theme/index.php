<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <!-- Add your external CSS/JS libraries here -->
    <!-- Example: <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    
    <?php wp_head(); ?>
    
    <!-- Add your custom inline styles here -->
    <style>
        /* Your original website CSS goes here */
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- 
    Replace this section with your original website HTML structure
    Remember to:
    1. Keep the WordPress function calls (wp_head, wp_footer, etc.)
    2. Update image paths to use get_template_directory_uri()
    3. Update links to use WordPress functions like home_url()
    -->
    
    <div class="site-container">
        <h1>Your Migrated Website</h1>
        <p>Replace this with your original HTML content.</p>
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>