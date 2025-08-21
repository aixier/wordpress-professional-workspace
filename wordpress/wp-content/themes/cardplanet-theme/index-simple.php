<?php get_header(); ?>

<div class="cardplanet-test">
    <h1>🎉 CardPlanet主题工作正常！</h1>
    <p>这是简化版本的CardPlanet主题首页。</p>
    <p>原始设计来自：<strong>/mnt/d/work/wordpress_pages/cardplanet.me</strong></p>
    <p>WordPress版本：<?php echo get_bloginfo('version'); ?></p>
    <p>主题名称：<?php echo wp_get_theme()->get('Name'); ?></p>
</div>

<style>
.cardplanet-test {
    max-width: 800px;
    margin: 50px auto;
    padding: 40px;
    text-align: center;
    font-family: 'Inter', Arial, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.cardplanet-test h1 {
    color: #2c3e50;
    margin-bottom: 20px;
}

.cardplanet-test p {
    color: #34495e;
    line-height: 1.6;
    margin: 10px 0;
}
</style>

<?php get_footer(); ?>