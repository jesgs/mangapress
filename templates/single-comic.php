<?php
/**
 * MangaPress
 *
 * @package Manga_Press
 * @subpackage Manga_Press_Templates\Single_Comic
 * @version $Id$
 * @author Jess Green <jgreen@psy-dreamer.com>
 */
?>
<?php mangapress_comic_navigation(); ?>

<div class="mangapress-media-img">
    <?php echo wp_get_attachment_image( get_post_thumbnail_id(), $thumbnail_size, false );?>
</div>
