<script type="text/javascript">
  var pluginDirectory = '<?php echo plugins_url('', __FILE__); ?>';
  ajaxGetYoutube.query = '<?php echo get_option( 'yt_to_posts_query', '' ) ?>';
  ajaxGetYoutube.queryType = '<?php echo get_option( 'yt_to_posts_query_type', '' ) ?>';
  ajaxGetYoutube.number = '<?php echo get_option( 'yt_to_posts_number', '' ) ?>';
  ajaxGetYoutube.currentCat = '<?php echo get_option( 'yt_to_posts_cat', '' ) ?>';
  ajaxGetYoutube.trans.approve = '<?php _e('Approve', 'youtube-to-posts') ?>';
  ajaxGetYoutube.trans.deny = '<?php _e('Deny', 'youtube-to-posts') ?>';
  ajaxGetYoutube.trans.needUpdate = '<?php _e('You have changed the query parameters, remember to click on Save Changes to update the results.', 'youtube-to-posts') ?>';
  ajaxGetYoutube.trans.apiWrong = '<?php _e('There is an error with your API key, it has been rejected by Google API Service.', 'youtube-to-posts') ?>';
  ajaxGetYoutube.trans.loading = '<?php _e('Loading...', 'youtube-to-posts') ?>';
  ajaxGetYoutube.trans.mediaAdded = '<?php _e('Video added !', 'youtube-to-posts') ?>';
  ajaxGetYoutube.trans.mediaRejected = '<?php _e('Video rejected !', 'youtube-to-posts') ?>';
</script>

<div class="wrap">
  <h2 class="align-center">Import YouTube videos as WP Posts</h2>

  <?php if(yt_check_api_settings()){ ?>
  <h3><?php _e('Youtube query options', 'youtube-to-posts') ?></h3>
  <form method="post" action="options.php" class="options-custom" id="queryOptions">

    <?php
    settings_fields( 'yt_to_posts-query-settings-group' ); ?>
    <?php do_settings_sections( 'yt_to_posts-query-settings-group' ); ?>
    <div class="option">
      <label><?php _e('Query type:', 'youtube-to-posts') ?></label>
      <select name="yt_to_posts_query_type">
        <option <?php if(esc_attr( get_option('yt_to_posts_query_type') ) === 'channel'){ echo 'selected'; } ?> value="channel">Channel</option>
        <option <?php if(esc_attr( get_option('yt_to_posts_query_type') ) === 'playlist'){ echo 'selected'; } ?> value="playlist">Playlist</option>
        <option <?php if(esc_attr( get_option('yt_to_posts_query_type') ) === '' || esc_attr( get_option('yt_to_posts_query_type') ) === 'free'){ echo 'selected'; } ?> value="free">Search with keywords</option>
      </select>

    </div>
    <div class="option">
      <label><?php _e('Query:', 'youtube-to-posts') ?></label>
      <input type="text" placeholder="<?php _e('Type your query.', 'youtube-to-posts') ?>" name="yt_to_posts_query" value="<?php echo esc_attr( get_option('yt_to_posts_query') ); ?>" />
      <p class="description"><?php _e('If your query type is a playlist or a user, then you must type the relevant playlist / user ID.', 'youtube-to-posts') ?></p>
    </div>

    <div class="option">
      <label><?php _e('Max results?', 'youtube-to-posts') ?></label>
      <input type="number" min="1" max="50" placeholder="<?php _e('Default value is 30', 'youtube-to-posts') ?>" name="yt_to_posts_number" value="<?php echo esc_attr( get_option('yt_to_posts_number') ); ?>" /></td>

    </div>
    <div class="option">
      <label><?php _e('Post type to feed:', 'youtube-to-posts') ?></label>

      <select id="updateCatOnChange" name="yt_to_posts_post_type">
        <?php
        $types = get_post_types(array('public'   => true));

        foreach ($types as $type) {
        if($type === 'page' || $type === 'attachment'){
        // do nothing
        }
        else {
        ?>
        <option value="<?php echo $type; ?>" <?php if(esc_attr( get_option('yt_to_posts_post_type') ) === $type){ echo 'selected'; } ?> ><?php echo $type; ?></option>
        <?php }
        }
        ?>
      </select>
      <p class="description"><?php _e('If you select a custom post type, be sure it supports Post Thumbnails.', 'youtube-to-posts') ?></p>
    </div>
    <div class="option">
      <label><?php _e('Post status of created posts:', 'youtube-to-posts') ?></label>

      <select id="updateCatOnChange" name="yt_to_posts_post_status">
        <?php
        $stati = yt_to_posts_getStati();

        foreach ($stati as $status) {

        ?>
        <option value="<?php echo $status; ?>" <?php if(esc_attr( get_option('yt_to_posts_post_status') ) === $status){ echo 'selected'; } ?> ><?php echo $status; ?></option>
        <?php
          }
        ?>
      </select>
      <p class="description"><?php _e('If you select a custom post type, be sure it supports Post Thumbnails.', 'youtube-to-posts') ?></p>
    </div>
    <div class="option" id="catsSelect">
      <label><?php _e('Taxonomy term to feed:', 'youtube-to-posts') ?></label>

      <select name="yt_to_posts_cat" >
        <?php

        $args = array(

        'hide_empty'               => 0
        );
        $terms = get_categories($args);
        foreach ($terms as $term) { ?>
        <option value="<?php echo $term->term_id; ?>" <?php if(get_option('yt_to_posts_cat') == $term->term_id){ echo 'selected'; } ?> ><?php echo $term->name; ?></option>
        <?php }
        ?>
      </select>
    </div>
    <div class="option">
      <label><?php _e('Published:', 'youtube-to-posts') ?></label>

      <select name="yt_to_posts_author" >
        <?php

        $args = array(

        'hide_empty'               => 0
        );
        $users = get_users();
        foreach ($users as $user) { ?>
        <option value="<?php echo $user->ID; ?>" <?php if(esc_attr( get_option('yt_to_posts_author') ) === $user->ID){ echo 'selected'; } ?> ><?php echo $user->display_name; ?></option>
        <?php }
        ?>
      </select>
    </div>
    <div id="updateNotifs">
    </div>
    <div class="align-center">
      <?php submit_button(); ?>
    </div>
  </form>
  <h3><?php _e('Results from Youtube for:', 'youtube-to-posts') ?> "<?php echo get_option( 'yt_to_posts_query', '' ) ?>"</h3>
  <p class="description"><?php _e('Results are ordered by date, newest first.', 'youtube-to-posts') ?></p>
  <div class="updated updated-custom">
    <p><?php _e('Media added !', 'youtube-to-posts') ?></p>
  </div>
  <div id="headResults">
    <div class="manage-column column-image"><strong><?php _e('Video preview', 'youtube-to-posts') ?></strong></div>
    <div class="manage-column column-auteur"><strong><?php _e('Video title', 'youtube-to-posts') ?></strong></div>
    <div class="manage-column column-texte"><strong><?php _e('Video description', 'youtube-to-posts') ?></strong></div>
    <div class="manage-column column-date"><strong><?php _e('Upload date', 'youtube-to-posts') ?></strong></div>
    <div class="manage-column column-action"><strong><?php _e('Actions', 'youtube-to-posts') ?></strong></div>
  </div>
  <div id="results-0" class="results">
    <span><?php _e('Getting the posts, please wait...', 'youtube-to-posts') ?></span>
  </div>
  <div class="align-center" id="btnContainer">
    <a href="#" class="button button-primary hidden" id="loadMore"><?php _e('Load more videos', 'youtube-to-posts') ?></a>
    <a href="#" class="button button-primary hidden" data-loading-str="<?php _e('Adding videos, please wait...', 'youtube-to-posts') ?>" data-default-str="<?php _e('Approve all listed videos', 'youtube-to-posts') ?>" id="approveAllBtn"><?php _e('Approve all listed videos', 'youtube-to-posts') ?></a>
  </div>
  <?php
  } else { ?>
  <p><?php _e('Your Youtube API access is not defined, go set it on the <a href="options-general.php?page=youtube-to-posts">settings page</a>.', 'youtube-to-posts') ?></p>
  <?php
  }?>
</div>
