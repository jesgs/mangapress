<?php
/**
 *
 */

namespace MangaPress\Theme\Compatible;

use MangaPress\Theme\Interfaces\Theme;
use MangaPress\Theme\Traits\Markup;

/**
 * Class Twentysixteen
 * @package MangaPress\Theme\Compatible
 */
class Twentysixteen implements Theme
{
    use Markup;

    public function init()
    {
        add_action('mangapress_page_header', [$this, 'page_header']);

        add_action('mangapress_before_content', [$this, 'before_content']);
        add_action('mangapress_after_content', [$this, 'after_content']);

        add_action('mangapress_article_header', [$this, 'article_header']);
    }

    public function page_header()
    {
        ?>

        <div id="page" class="site">
        <div class="site-inner">
        <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'twentysixteen'); ?></a>

        <header id="masthead" class="site-header" role="banner">
            <div class="site-header-main">
                <div class="site-branding">
                    <?php twentysixteen_the_custom_logo(); ?>
                    <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                             rel="home"><?php bloginfo('name'); ?></a></p>
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) :
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <?php if (has_nav_menu('primary') || has_nav_menu('social')) : ?>
                    <button id="menu-toggle" class="menu-toggle"><?php _e('Menu', 'twentysixteen'); ?></button>

                    <div id="site-header-menu" class="site-header-menu">
                        <?php if (has_nav_menu('primary')) : ?>
                            <nav id="site-navigation" class="main-navigation" role="navigation"
                                 aria-label="<?php esc_attr_e('Primary Menu', 'twentysixteen'); ?>">
                                <?php
                                wp_nav_menu(
                                    [
                                        'theme_location' => 'primary',
                                        'menu_class'     => 'primary-menu',
                                    ]
                                );
                                ?>
                            </nav><!-- .main-navigation -->
                        <?php endif; ?>

                        <?php if (has_nav_menu('social')) : ?>
                            <nav id="social-navigation" class="social-navigation" role="navigation"
                                 aria-label="<?php esc_attr_e('Social Links Menu', 'twentysixteen'); ?>">
                                <?php
                                wp_nav_menu(
                                    [
                                        'theme_location' => 'social',
                                        'menu_class'     => 'social-links-menu',
                                        'depth'          => 1,
                                        'link_before'    => '<span class="screen-reader-text">',
                                        'link_after'     => '</span>',
                                    ]
                                );
                                ?>
                            </nav><!-- .social-navigation -->
                        <?php endif; ?>
                    </div><!-- .site-header-menu -->
                <?php endif; ?>
            </div><!-- .site-header-main -->

            <?php if (get_header_image()) : ?>
                <?php
                /**
                 * Filter the default twentysixteen custom header sizes attribute.
                 *
                 * @param string $custom_header_sizes sizes attribute
                 * for Custom Header. Default '(max-width: 709px) 85vw,
                 * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
                 * @since Twenty Sixteen 1.0
                 *
                 */
                $custom_header_sizes = apply_filters(
                    'twentysixteen_custom_header_sizes',
                    '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'
                );
                ?>
                <div class="header-image">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <img src="<?php header_image(); ?>"
                             srcset="<?php echo esc_attr(wp_get_attachment_image_srcset(get_custom_header()->attachment_id)); ?>"
                             sizes="<?php echo esc_attr($custom_header_sizes); ?>"
                             width="<?php echo esc_attr(get_custom_header()->width); ?>"
                             height="<?php echo esc_attr(get_custom_header()->height); ?>"
                             alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
                    </a>
                </div><!-- .header-image -->
            <?php endif; // End header image check.
            ?>
        </header><!-- .site-header -->

        <div id="content" class="site-content">
        <?php
    }

    public function before_content()
    {
        echo '<div id="primary" class="content-area">' . "\r\n";
        echo '<main id="main" class="site-main" role="main">' . "\r\n";
    }

    public function after_content()
    {
        echo '</main><!-- .site-main -->';
        get_sidebar('content-bottom');
        echo '</div><!-- .content-area -->';
    }

    public function article_header()
    {
        echo '<header class="entry-header">';
        the_title('<h1 class="entry-title">', '</h1>');
        echo '</header><!-- .entry-header -->';
    }
}