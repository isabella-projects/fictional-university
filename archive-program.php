<?php
get_header();

pageBanner([
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone. Have a look around'
]);
?>

<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        <?php while (have_posts()) : the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
        <!-- Pagination depending on posts length (adjust if needed in WP-Admin) -->
        <?= paginate_links(); ?>
    </ul>
</div>

<?php get_footer(); ?>