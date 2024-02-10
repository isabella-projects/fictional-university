<?php
get_header();

pageBanner([
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events'
]);
?>

<div class="container container--narrow page-section">
    <?php
    $today = date('Ymd');
    $pastEvents = new WP_Query([
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        // Remove past event from Events table with meta
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => 'event_date',
                'compare' => '<',
                'value' => $today,
                'type' => 'numeric'
            ]
        ]
    ]);

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('templates/content-event');
    }

    // Pagination depending on posts length (adjust if needed in WP-Admin)
    echo paginate_links([
        'total' => $pastEvents->max_num_pages
    ]);
    ?>

</div>

<?php get_footer(); ?>