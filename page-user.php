<div id="user-page">
  <?php if (!isset($_GET['id']) || !is_numeric($_GET['id'])) : ?>
      <p><?php _e('The user doesn\'t exist.'); ?></p>
  <?php else: ?>
      <?php $user = get_user($_GET['id']); ?>
      <h2><?php _e('User details'); ?></h2>
      <p><b><?php _e('Name'); ?>:</b> <?php echo $user['name']; ?></p>
      <p><b><?php _e('Username'); ?>:</b> <?php echo $user['username']; ?></p>
      <p><b><?php _e('Phone'); ?>:</b> <?php echo $user['phone']; ?></p>
      <p><b><?php _e('Address'); ?>:</b> <?php echo $user['address']; ?></p>
      <p><b><?php _e('Description'); ?>:</b> <?php echo $user['description']; ?></p>
      <p>
        <b><?php _e('Role'); ?>:</b> 
        <?php if ($user['role'] == '1') : ?>
            <?php _e('Admin'); ?>
        <?php else: ?>
            <?php _e('User'); ?>
        <?php endif; ?>
      </p>
      <?php if(user_role() == 1) : ?>
          <p><a href="index.php?p=edit-user&id=<?php echo $user['id']; ?>"><b><?php _e('Edit user'); ?></b></a></p>
      <?php endif; ?>
  <?php endif; /* if (!isset($_GET['id']) || !is_numeric($_GET['id'])) */ ?> 
</div> <!-- #user-page -->
