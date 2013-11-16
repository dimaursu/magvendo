<div id="vendor-details">
  <?php if (!isset($_GET['id']) || !is_numeric($_GET['id'])) : ?>
      <p><?php _e('The vendor doesn\'t exist.'); ?></p>
  <?php else: ?>
      <?php $vendor = get_vendor($_GET['id']); ?>
      <h2><?php _e('Vendor details'); ?></h2>
      <p><b><?php _e('Vendor name'); ?>:</b> <?php echo $vendor['name']; ?></p>
      <p><b><?php _e('Phone'); ?>:</b> <?php echo $vendor['phone']; ?></p>
      <p><b><?php _e('Email'); ?>:</b> <?php echo $vendor['email']; ?></p>
      <p><b><?php _e('Address'); ?>:</b> <?php echo $vendor['address']; ?></p>
      <p><b><?php _e('Description'); ?>:</b> <?php echo $vendor['description']; ?></p>
      <p><a href="index.php?p=edit-vendor&id=<?php echo $vendor['id']; ?>"><b><?php _e('Edit vendor'); ?></b></a></p>
  <?php endif; /* if (!isset($_GET['id']) || !is_numeric($_GET['id'])) */ ?> 
</div> <!-- #vendor-details -->
