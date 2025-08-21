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
            background: transparent;
            z-index: 1000;
            padding: 24px 0;
            transition: all 0.4s ease;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }
        
        /* Capsule-shaped transparent frosted background */
        .nav-container::before {
            content: '';
            position: absolute;
            left: 15px;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            height: 64px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: -1;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 500;
            color: var(--text-accent);
            letter-spacing: 0.02em;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 40px;
            align-items: center;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 400;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            color: var(--text-primary);
        }
        
        .auth-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--soft-gold);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .auth-btn:hover {
            background: var(--warm-gold);
            transform: translateY(-1px);
        }
        
        /* Hero Section */
        .hero {
            padding: 120px 0 80px;
        }
        
        .hero-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 32px;
            color: var(--text-primary);
        }
        
        .highlight {
            background: linear-gradient(135deg, var(--soft-gold) 0%, var(--warm-gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 48px;
        }
        
        .cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 36px;
            background: var(--soft-gold);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--glow-shadow);
        }
        
        .cta-primary:hover {
            background: var(--warm-gold);
            box-shadow: var(--hover-glow);
            transform: translateY(-2px);
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
        }
        
        .feature-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            margin-bottom: 120px;
        }
        
        .feature-content h3 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--text-primary);
        }
        
        .feature-content p {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 20px;
        }
        
        .feature-visual {
            background: var(--silver-mist);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
        }
        
        /* Showcase Gallery */
        .showcase-gallery {
            padding: 80px 0;
            background: var(--silver-mist);
        }
        
        .showcase-header {
            text-align: center;
            margin-bottom: 64px;
        }
        
        .showcase-header h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--text-primary);
        }
        
        .showcase-header p {
            font-size: 1.1rem;
            color: var(--text-secondary);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .feature-row {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .container {
                padding: 0 20px;
            }
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <div class="main-page">
        <!-- Navigation -->
        <nav>
            <div class="container">
                <div class="nav-container">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                        🪐 CardPlanet
                    </a>
                    
                    <ul class="nav-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#showcase">Gallery</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    
                    <a href="#contact" class="auth-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10 9 11 5.16-1 9-5.45 9-11V7l-10-5z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                        Get Started
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>
                        Turn your ideas into stunning<br>
                        shareable <span class="highlight">knowledge cards</span>
                    </h1>
                    <p>
                        Convert your complex ideas into visually engaging cards that simplify information, boost engagement, and skyrocket shares. AI-powered, 12 design styles, optimized for all social platforms.
                    </p>
                    <a href="#" class="cta-primary">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" fill="#ff6b6b"/>
                        </svg>
                        Start Creating Free
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Card Showcase Gallery -->
        <section class="showcase-gallery" id="showcase">
            <div class="showcase-header">
                <h2>Real Examples Created with CardPlanet</h2>
                <p>Click on any card to view the complete case study</p>
            </div>
        </section>

        <!-- Features -->
        <section class="features" id="features">
            <div class="container">
                <!-- Feature 1 -->
                <div class="feature-row">
                    <div class="feature-content">
                        <h3>One-Click Generation, No Design Experience Needed</h3>
                        <p>Enter keywords or paste text, and AI instantly generates complete card content and design. From title optimization to content structure, from visual design to style matching, the entire process takes less than 5 minutes.</p>
                        <p>Supports mixed English and international content, automatic layout optimization, and intelligent color scheme recommendations. Every card is meticulously fine-tuned by AI to ensure visual impact and shareability.</p>
                    </div>
                    
                    <div class="feature-visual">
                        <p>🎨 AI-Powered Design Generation</p>
                        <p>Transform your ideas into beautiful cards instantly</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php wp_footer(); ?>
</body>
</html>