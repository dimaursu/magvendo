<?php



?>
<div id="customer-page">
  <?php if (!isset($_GET['id']) || !is_numeric($_GET['id'])) : ?>
      <p><?php _e('The customer doesn\'t exist.'); ?></p>
  <?php else: ?>
      <h2><?php _e('Customer'); ?></h2>
      <?php $customer = mag_get_customer($_GET['id']); ?>
      <?php if (empty($customer)) : ?>
          <p><?php _e('The customer doesn\'t exist.'); ?></p>
      <?php else: ?>
          <p><b><?php _e('Name'); ?>:</b> <?php echo $customer['name']; ?></p>
          <p><b><?php _e('Phone'); ?>:</b> <?php echo $customer['phone']; ?></p>
          <p><b><?php _e('Email'); ?>:</b> <a href="mailto:<?php echo $customer['email']; ?>"><?php echo $customer['email']; ?></a></p>
          <p><b><?php _e('Birthday'); ?>:</b> <?php echo $customer['birthday']; ?></p>
          <p><a href="index.php?p=edit-customer&id=<?php echo $customer['id']; ?>"><b><?php _e('Edit'); ?></b></a></p>
          <h3><?php _e('Card'); ?></h3>
          <p style="padding-left: 1em;"><b><?php _e('Number'); ?>:</b> <a href="index.php?p=card"><?php echo $customer['card']; ?></a></p>
          <?php $card = mag_card_sales($customer['card']); ?>
          <p style="padding-left: 1em;"><b><?php _e('Sum'); ?>:</b> <?php echo ceil($card['sales']); ?> <?php _e('Lei'); ?></p>
      <?php endif; /* <?php if (empty($customer)) : ?> */?>
  <?php endif; /* if (!isset($_GET['id']) || !is_numeric($_GET['id'])) */ ?> 
</div> <!-- #customer-page -->