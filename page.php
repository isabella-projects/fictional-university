<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    pageBanner([
        'title' => 'Hello there is the test',
        'subtitle' => 'Hi, this is test subtitle',
        'photo' => 'https://images.unsplash.com/photo-1707464568815-7fb6b6ea3e2a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
    ]); ?>

    <div class="container container--narrow page-section">
        <?php $theParent = wp_get_post_parent_id(get_the_ID());
        if ($theParent) : ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?= get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i><?= get_the_title($theParent) ?></a> <span class="metabox__main"><?php the_title();  ?></span>
                </p>
            </div>
        <?php endif; ?>

        <?php $testArray = get_pages([
            'child_of' => get_the_ID()
        ]);
        if ($theParent || $testArray) : ?>
            <div class="page-links">
                <h2 class="page-links__title"><a href="<?= get_permalink($theParent); ?>"><?= get_the_title($theParent); ?></a></h2>
                <ul class="min-list">
                    <?php
                    if ($theParent) {
                        $findChilderOf = $theParent;
                    } else {
                        $findChilderOf = get_the_ID();
                    }

                    wp_list_pages([
                        'title_li' => NULL,
                        'child_of' => $findChilderOf,
                        'sort_column' => 'menu_order'
                    ]);
                    ?>
                </ul>
            </div>
        <?php endif; ?>


        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>