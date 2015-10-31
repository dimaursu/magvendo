<div id="settings-page">
  <h2><?php _e('Settings'); ?></h2>

  <form enctype="multipart/form-data" action="index.php?p=settings" method="post">
    <p><input type="checkbox" name="main_menu" <?php if (get_settings('show_menu')) : ?>checked="chekced"<?php endif; ?> value="1">
    <?php _e('Show main menu'); ?></p>
   <p><input class="button" type="submit" name="save_settings" value="<?php _e('Save'); ?>"></p>  
  </form>

</div> <!-- #page-setings -->
