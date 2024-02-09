<?php get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">All Events</h1>
        <div class="page-banner__intro">
            <!-- WP-Admin - Users/Your Profile/Description also for Posts/Categories/Description(for categories) -->
            <p>See what is going on in our world..</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php while (have_posts()) : the_post(); ?>
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
    <?= paginate_links(); ?>

    <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?= site_url('/past-events'); ?>">Check out our past events archive</a>.</p>
</div>

<?php get_footer(); ?>