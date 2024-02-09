<?php get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events</h1>
        <div class="page-banner__intro">
            <!-- WP-Admin - Users/Your Profile/Description also for Posts/Categories/Description(for categories) -->
            <p>A recap of our past events.</p>
        </div>
    </div>
</div>

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

    ?>
    <?php while ($pastEvents->have_posts()) : $pastEvents->the_post(); ?>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month">
                    <?php
                    $eventMonth = new DateTime(get_field('event_date'));
                    echo $eventMonth->format('M');
                    ?>
                </span>
                <span class="event-summary__day">
                    <?php
                    $eventDay = new DateTime(get_field('event_date'));
                    echo $eventDay->format('d');
                    ?>
                </span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?= wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
        </div>
    <?php endwhile; ?>
    <!-- Pagination depending on posts length (adjust if needed in WP-Admin) -->
    <?= paginate_links([
        'total' => $pastEvents->max_num_pages
    ]);
    ?>
</div>

<?php get_footer(); ?>