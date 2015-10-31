<div id="sider"> 
<?php if (isset($_SESSION['magsales']['magazine_id'])) : ?>
  <?php if(has_worker_role(SALE)) : ?>
    <h2><?php _e('Sales'); ?></h2>
    <ul>
        <li><a href="index.php?p=sale"><?php _e('Sale'); ?></a></li>
        <li><a href="index.php?p=sales"><?php _e('Sales list'); ?></a></li>
    </ul>
  <?php endif; ?>
<?php endif; ?>

<?php if (user_role() == ADMIN_ROLE) : ?>    
    <h2><?php _e('Admin'); ?></h2>
    <ul id="side-admin-menu">
      <li><a href="index.php?p=categories"><?php _e('Products'); ?></a></li>
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=customers"><?php _e('Customers'); ?></a></li>
      <li><a href="index.php?p=add-customer"><?php _e('Add customer'); ?></a></li>
      <li><span class="separator"></span></li>      
      <li><a href="index.php?p=statistics"><?php _e('Statistics'); ?></a></li> 
    </ul>
<?php endif; ?>

</div> <!-- #sider -->
