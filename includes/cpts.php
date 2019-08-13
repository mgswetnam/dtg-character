<?php
$cpts = array(
  'client' => array(
    'singular' => 'Client',
    'plural' => 'Clients',
    'description' => __( 'Cornerstone Advertising client listings.', 'csa_client' ),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => 'edit.php?post_type=client',
    'menu_icon' => 'dashicons-id',
    'query_var' => true,
    'rewrite' => array(
      'slug' => 'client'
    ),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => null,
    'show_in_rest' => true,
    'supports' => array(
      'title',
    ),
    'taxonomies' => array(
      'category'
    )
  )
);
?>
