<?php
// Add custom block category
add_filter( 'block_categories_all', function( $categories ) {
  return array_merge(
    array(
      array(
        'slug'  => 'vp-category',
        'title' => __( 'VidPress', 'vidpress' ),
        'icon'  => null,
      )
    ),
    $categories
  );
}, 999 );

// Disable remote block patterns
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Register video-related scripts
 */
add_action( 'wp_enqueue_scripts', function () {
  // Register custom VidPress video script
  wp_register_script(
    'vidpress-video',
    VIDPRESS_URL . '/assets/vidpress-video.js',
    [ 'jquery' ],
    VIDPRESS_VERSION,
    true
  );

  // Register external APIs
  wp_register_script(
    'vimeo_embed_api',
    'https://player.vimeo.com/api/player.js',
    [],
    VIDPRESS_VERSION,
    true
  );

  wp_register_script(
    'yt_embed_api',
    'https://www.youtube.com/iframe_api',
    [],
    VIDPRESS_VERSION,
    true
  );
} );
