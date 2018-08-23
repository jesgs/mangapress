<?php
/**
 * Manga+Press Latest Comic Template
 *
 * @package Manga_Press
 * @subpackage Manga_Press_Templates\Latest_Comic
 * @version $Id$
 * @author Jess Green <jgreen@psy-dreamer.com>
 */

get_header('comic');

/** This filter is documented in templates/single-comic.php */
do_action('mangapress_before_content'); ?>
<header class="entry-header mangapress-latest-comic-header">
    <h1 class="entry-title manga-press-latest-comic-header__title">
        <?php _e('Latest Comic', MP_DOMAIN); ?>
    </h1>
</header>

<?php
/**
 * mangapress_before_latest_comic
 *
 * Run scripts or insert content before latest comic loop conditional
 * @since 4.0.0
 */
do_action('mangapress_before_latest_comic'); ?>

<?php if (have_posts()) : ?>

    <?php
    /**
     * mangapress_before_latest_comic_loop
     *
     * Run scripts or insert content directly before latest comic loop
     * @since 4.0.0
     */
    do_action('mangapress_before_latest_comic_loop'); ?>
    <?php while(have_posts()) : the_post(); ?>
        <article <?php post_class() ?>>
            <header class="mangapress_comic_title">
               <h2><?php the_title(); ?></h2>
            </header>
            <?php the_post_thumbnail(); ?>
        </article>
        <?php mangapress_comic_navigation(); ?>
    <?php endwhile; ?>

    <?php
    /**
     * mangapress_after_latest_comic_loop
     *
     * Run scripts or insert content directly after latest comic loop
     * @since 4.0.0
     */
    do_action('mangapress_after_latest_comic_loop'); ?>

<?php endif; ?>


<?php
/**
 * mangapress_after_latest_comic
 *
 * Run scripts or insert content after latest comic loop conditional
 * @since 4.0.0
 */
do_action('mangapress_after_latest_comic'); ?>

<?php
/** This filter is documented in templates/single-comic.php */
do_action('mangapress_after_content'); ?>

<?php
/** This filter is documented in templates/single-comic.php */
do_action('mangapress_sidebar'); ?>

<?php get_footer('comic');