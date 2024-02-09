<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>DONT FORGET TO REPLACE ME LATER</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('program'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    All Programs
                </a>
                <span class="metabox__main">
                    <?php the_title(); ?>
                </span>
            </p>
        </div>
        <div class="generic-content"><?php the_content(); ?></div>

        <?php

        $relatedProfessors = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'related_program',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                ]
            ]
        ]);

        if ($relatedProfessors->have_posts()) :
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()) :
                $relatedProfessors->the_post();
        ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url(); ?>">
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>
            <?php
            endwhile;
            echo '</ul>';
        endif;

        wp_reset_postdata();

        $today = date('Ymd');
        $homepageEvents = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            // Remove past event from Events table with meta
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                ],
                [
                    'key' => 'related_program',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                ]
            ]
        ]);

        if ($homepageEvents->have_posts()) :
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
            while ($homepageEvents->have_posts()) :
                $homepageEvents->the_post();
            ?>
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
                        <p>
                            <?php if (has_excerpt()) : echo get_the_excerpt(); ?>
                            <?php else : echo wp_trim_words(get_the_content(), 18); ?>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
                        </p>
                    </div>
                </div>
        <?php
            endwhile;
        endif;
        ?>

    </div>
<?php endwhile; ?>

<?php get_footer(); ?>