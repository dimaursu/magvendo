<div id="general-info">
  <h2><?php _e('General information'); ?></h2>
  <p><b><?php _e('Organization'); ?></b>: <?php echo get_settings('organization'); ?></p>
  <p><b><?php _e('Phone'); ?></b>: <?php echo get_settings('organization_phone'); ?></p>
  <p><b><?php _e('Email'); ?></b>: <a href="mailto:<?php echo get_settings('organization_email'); ?>"><?php echo get_settings('organization_email'); ?></a></p>
  <p><b><?php _e('Address'); ?></b>: <?php echo get_settings('organization_address'); ?></p>
  <p><b><?php _e('Web'); ?></b>: <a href="<?php echo get_settings('organization_web'); ?>"><?php echo get_settings('organization_web'); ?></a></p>
</div> <!-- #general-info -->
