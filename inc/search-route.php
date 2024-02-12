<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_SERVER::READABLE, // same as 'GET' a.k.a WP const
        'callback' => 'universitySearchResults'
    ]);
}

function universitySearchResults($data)
{
    $professors = new WP_Query([
        'post_type' => 'professor',
        's' => sanitize_text_field($data['term'])
    ]);

    // Add only the needed content in an empty array to prevent users from downloading unnecessary data
    $professorResults = [];

    while ($professors->have_posts()) {
        $professors->the_post();
        array_push($professorResults, [
            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ]);
    }

    return $professorResults;
}
