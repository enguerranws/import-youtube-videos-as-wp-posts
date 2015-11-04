<script type="text/javascript">
    var pluginDirectory = '<?php echo plugins_url('', __FILE__); ?>';
    
</script>

<div class="wrap">
   <h2 class="align-center"><img src="<?php echo plugins_url('', __FILE__); ?>/img/logo-t2p.png"></h2>

   <form method="post" action="options.php">
   <?php settings_fields( 'yt_to_posts-admin-settings-group' ); ?>
    <?php do_settings_sections( 'yt_to_posts-admin-settings-group' ); ?>
    <h3><?php _e('Google Youtube API settings :', 'youtube-to-posts') ?></h3>
   <table class="form-table">
        
         <tr valign="top">
        <th scope="row"><?php _e('Google Youtube API key:', 'youtube-to-posts') ?></th>
        <td><input type="text" style="min-width:350px;" placeholder="<?php _e('Paste here your consumer key', 'youtube-to-posts') ?>" name="yt_to_posts_ck" value="<?php echo esc_attr( get_option('yt_to_posts_ck') ); ?>" /></td>
        </tr> 
        
    </table>
    <hr>
     <h3><?php _e('Post content format :', 'youtube-to-posts') ?></h3>
     <p class="description">
      <?php _e('You can customize the way Youtube content will feed your posts with a template tag system. So:', 'youtube-to-posts') ?>
      

    </p>
    <ul>
        <li><?php _e('{%title%} is the title of the Youtube video', 'youtube-to-posts') ?></li>
        <li><?php _e('{%description%} is the description (500 chars max - Youtube restriction) of the Youtube video', 'youtube-to-posts') ?></li>
        <li><?php _e('{%embed%} will display the embed code of the video', 'youtube-to-posts') ?></li>
        <li><?php _e('{%thumbnail%} will display the thumbnail of the video', 'youtube-to-posts') ?></li>
        <li><?php _e('{%query%} will display the query you typed', 'youtube-to-posts') ?></li>
        <li><?php _e('{%user%} will display the uploader of the video', 'youtube-to-posts') ?></li>
        <li><?php _e('{%date%} will display the upload date of the video', 'youtube-to-posts') ?></li>
      </ul>
   <table class="form-table">
        
         <tr valign="top">
        <th scope="row"><?php _e('Title format of your videos:', 'youtube-to-posts') ?><p class="description"><?php _e('Default title is just {%title%}', 'youtube-to-posts') ?></p></th>
        <td><input type="text" placeholder="<?php _e('e.g. Last Video of {%user%} - {%title%}', 'youtube-to-posts') ?>" style="min-width:350px;" name="yt_to_posts_title_format" value="<?php echo esc_attr( get_option('yt_to_posts_title_format') ); ?>" /></td>
        </tr> 
         <tr valign="top">
        <th scope="row"><?php _e('Content format of your videos:', 'youtube-to-posts') ?><p class="description"><?php _e('Default content is {%embed%}<br>{%description%}', 'youtube-to-posts') ?></p></th>
        <td><textarea placeholder="<?php _e('e.g. Last Video of {%user%} - {%title%}', 'youtube-to-posts') ?>" style="min-width:350px;" name="yt_to_posts_content_format" value="<?php echo esc_attr( get_option('yt_to_posts_content_format') ); ?>" /><?php echo esc_attr( get_option('yt_to_posts_content_format') ); ?></textarea><p class="description">HTML tags are allowed</p></td>
        </tr> 
    </table>
    <hr>
    <h3><?php _e('How can I get a Google API key?', 'youtube-to-posts') ?></h3>
    <p class="description">
      <?php _e('To use this plugin, you\'ll need to create a Google Youtube API key. Dealing with Google Developers Console can be a bit confusing, you need to : create a project, make the API data you need active and generate a public API key. Here\'s how to do that:', 'youtube-to-posts') ?>
      

    </p>
    <ol>
      <li><?php _e('Login to Google using your Google account.', 'youtube-to-posts') ?>
      </li>
      <li><?php _e('Go to the <a target="_blank" href="https://console.developers.google.com/project">Developers Console > Projects</a>', 'youtube-to-posts') ?></li>
      <li><?php _e('Click on "Create a project" (you\'ll need to give it a title and an ID)', 'youtube-to-posts') ?></li>
      <li><?php _e('When your project his created, click on it on the project list', 'youtube-to-posts') ?></li>
      <li><?php _e('Go to the section API and authentication > API, and search for YouTube Data API v3, and click on the button on the right to make this API active.', 'youtube-to-posts') ?></li>
      <li><?php _e('Go to the Credentials section > Access to the public API anc click on the button "Make a key" > Server key', 'youtube-to-posts') ?></li>
      <li><?php _e('On the next box, you\'ll need to tell on which domains you allow the use of your app (e.g. 127.0.0.1, www.mydomain.com, etc).', 'youtube-to-posts') ?></li>
      <li><?php _e('Now it should have generated a API Key (e.g. AIzaFyD0aPCQjLFRbLnh4RKbVBlBgVCVSwjbFAg), copy-paste it on the box above.', 'youtube-to-posts') ?></li>
      <li><?php _e('It\'s done, congrats :)', 'youtube-to-posts') ?></li>
    </ol>
    <?php submit_button(); ?>

</form>
</div>