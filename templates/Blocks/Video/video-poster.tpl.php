
<?php
 use VidPress\Helper\VpPosts;

  $video_id          = '';
  $video_playlist_id = '';
  $video_thumbnail   = '';

  $video_url      = $attributes['video_url'] ?? '';
  $video_provider = $attributes['video_provider'] ?? '';
  $aspect_ratio   = $attributes['ratio'] ?? 'ratio-16-9';
  $template       = '';

  if ($video_provider === 'youtube' && !empty($video_url)) {
    $video_data        = VpPosts::youtubeExtractVideoAndPlaylistId($video_url);
    $video_id          = $video_data['videoId'] ?? '';
    $video_playlist_id = $video_data['playlistId'] ?? '';
    $video_thumbnail   = VpPosts::getYouTubeThumbnail($video_id, 'maxresdefault');
  } elseif ($video_provider === 'vimeo' && !empty($video_url)) {
    $video_id = VpPosts::extractVimeoId($video_url);
    $video_thumbnail = VpPosts::getVimeoThumbnail($video_id);
  }

  $unique_id = uniqid('vidpress-');

  $link_attributes = sprintf(
    "data-block-id='%s' data-video-id='%s' data-video-provider='%s' data-playlist-id='%s'",
    $unique_id,
    $video_id,
    $video_provider,
    (!empty($video_playlist_id) ? $video_playlist_id : ''),
  );
?>
<div class="vidpress <?php echo esc_attr($attributes['className']); ?>">
  <div class="vidpress__container">
    <div class="vidpress__frame <?php echo esc_html($aspect_ratio); ?>">
      <a href="#" class="vidpress__link" <?php echo esc_html($link_attributes); ?>>
        <svg class="vidpress__play-icon" width="48" height="48" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="39" cy="39" r="38" stroke="#ffffff" stroke-width="2" fill="rgba(0, 0, 0, 0.6)"/>
          <polygon points="33,28 53,39 33,50" fill="#ffffff"/>
        </svg>
        <span class="vidpress__loading vidpress-hide">
          <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="25" r="20" stroke="#3498db" stroke-width="4" fill="none" stroke-dasharray="31.4 31.4">
              <animateTransform
                attributeName="transform"
                type="rotate"
                from="0 25 25"
                to="360 25 25"
                dur="1s"
                repeatCount="indefinite"/>
            </circle>
          </svg>
        </span>
        <?php if(!empty($video_thumbnail)) : ?>
          <img
            onerror="this.style.visibility='hidden'; this.style.fontSize=0"
            class="vidpress__thumbnail <?php echo esc_html($aspect_ratio); ?>"
            src="<?php echo esc_url($video_thumbnail); ?>"
            alt="<?php echo esc_html($video_provider) ?? ''; ?>"
          >
        <?php endif; ?>
      </a>
      <section class="vidpress__section-video <?php echo esc_html($aspect_ratio) ?? ''; ?>">
        <div id="vidpress-video-inline-<?php echo esc_html($unique_id) . '-' . esc_html($video_id) ?>" class="vidpress-hide"></div>
      </section>
    </div>
  </div>
</div>
