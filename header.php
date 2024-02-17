<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?= site_url() ?>"><strong>Fictional</strong> University</a>
            </h1>
            <a href="<?= esc_url(site_url('/search')) ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <!-- WordPress Dynamic Menu (current not in usage) -->
                    <!-- <?php
                            wp_nav_menu([
                                'theme_location' => 'headerMenuLocation'
                            ]);
                            ?> -->
                    <ul>
                        <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 13) echo 'class="current-menu-item"' ?>><a href="<?= site_url('/about-us'); ?>">About Us</a></li>
                        <li <?php if (get_post_type() == 'program') echo 'class="current-menu-item"' ?>><a href="<?= get_post_type_archive_link('program') ?>">Programs</a></li>
                        <li <?php if (get_post_type() == 'event' || is_page('past-events')) echo 'class="current-menu-item"' ?>><a href="<?= get_post_type_archive_link('event'); ?>">Events</a></li>
                        <li><a href="#">Campuses</a></li>
                        <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?= site_url('/blog'); ?>">Blog</a></li>
                    </ul>
                </nav>
                <div class="site-header__util">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?= wp_logout_url() ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                            <span class="site-header__avatar"><?= get_avatar(get_current_user_id(), 60) ?></span>
                            <span class="btn__text">Log Out</span>
                        </a>
                    <?php else : ?>
                        <a href="<?= wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                        <a href="<?= wp_registration_url(); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                    <?php endif; ?>
                    <a href="<?= esc_url(site_url('/search')) ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </header>