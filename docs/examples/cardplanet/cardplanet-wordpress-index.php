<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CardPlanet - AI-Powered Creative Card Design Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Inter Font System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Warm Minimalist Future Aesthetic Color System */
        :root {
            /* Main Base - Pure White & Silver */
            --clean-white: #ffffff;
            --warm-white: #fefefe;
            --silver-mist: #f8f9fa;
            --light-silver: #f5f6f7;
            
            /* Warm Accent Colors */
            --cream-light: #fef9f3;  /* Cream light */
            --soft-gold: #f4d03f;    /* Soft gold */
            --warm-gold: #f7dc6f;    /* Warm gold */
            
            /* Subtle Secondary Colors */
            --micro-blue: #f8fbff;   /* Micro blue */
            --soft-green: #f9fdf9;   /* Soft green */
            --pearl-glow: #fefcf8;   /* Pearl glow */
            
            /* Typography System */
            --text-primary: #1a1a1a;
            --text-secondary: #4a4a4a;
            --text-light: #888888;
            --text-accent: #6B8E23;  /* Natural green for logo */
            
            /* Effect System */
            --glow-shadow: 0 0 20px rgba(244, 208, 63, 0.1);
            --micro-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            --hover-glow: 0 0 30px rgba(244, 208, 63, 0.15);
            
            /* Additional for dashboard */
            --border-light: rgba(0, 0, 0, 0.06);
            --success-green: #10b981;
            --danger-red: #ef4444;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            
            /* Warm gradient background */
            background: 
                radial-gradient(ellipse at top left, var(--cream-light) 0%, transparent 50%),
                radial-gradient(ellipse at top right, var(--micro-blue) 0%, transparent 50%),
                radial-gradient(ellipse at bottom left, var(--soft-green) 0%, transparent 50%),
                radial-gradient(ellipse 800px 400px at 25% 85%, rgba(210, 247, 220, 0.4) 0%, transparent 40%),
                var(--warm-white);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.7;
        }
        
        /* Container System */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
        }
        
        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.4s ease;
            border-bottom: 1px solid var(--border-light);
        }
        
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 600;
            color: var(--text-accent);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 32px;
        }
        
        .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: var(--text-accent);
        }
        
        /* Hero Section */
        .hero {
            padding: 150px 0 100px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 4rem;
            font-weight: 600;
            margin-bottom: 24px;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 48px;
        }
        
        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: var(--soft-gold);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: var(--glow-shadow);
        }
        
        .cta-button:hover {
            box-shadow: var(--hover-glow);
            transform: translateY(-2px);
        }
        
        .cardplanet-success {
            color: var(--success-green);
            font-size: 1.5rem;
            margin: 32px 0;
        }
        
        .wordpress-info {
            background: var(--silver-mist);
            padding: 24px;
            border-radius: 12px;
            margin: 32px auto;
            max-width: 600px;
        }
        
        .wordpress-info h3 {
            color: var(--text-accent);
            margin-bottom: 16px;
        }
        
        .wordpress-info p {
            color: var(--text-secondary);
            margin: 8px 0;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .container {
                padding: 0 20px;
            }
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Navigation -->
    <nav>
        <div class="container">
            <div class="nav-container">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    🪐 CardPlanet
                </a>
                
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="cardplanet-success">
                ✅ CardPlanet WordPress主题成功运行！
            </div>
            
            <h1>AI-Powered Creative Card Design Platform</h1>
            <p>Transform your ideas into stunning card designs with our cutting-edge AI technology. Create, customize, and share beautiful cards in minutes.</p>
            
            <a href="#start" class="cta-button">
                <i class="fas fa-magic"></i>
                Start Creating
            </a>
            
            <div class="wordpress-info">
                <h3>🎉 WordPress迁移完成</h3>
                <p><strong>原始站点：</strong> /mnt/d/work/wordpress_pages/cardplanet.me</p>
                <p><strong>WordPress版本：</strong> <?php echo get_bloginfo('version'); ?></p>
                <p><strong>主题：</strong> <?php echo wp_get_theme()->get('Name'); ?></p>
                <p><strong>状态：</strong> <span style="color: var(--success-green);">✅ 主题激活并正常运行</span></p>
                <p><strong>访问地址：</strong> <a href="http://localhost:8080/" target="_blank">http://localhost:8080/</a></p>
            </div>
        </div>
    </section>

    <?php wp_footer(); ?>
</body>
</html>