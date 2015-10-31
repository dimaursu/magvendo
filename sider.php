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

<?php if(user_role() == ADMIN_ROLE) : ?>    
    <h2><?php _e('Admin'); ?></h2>
    <ul id="side-admin-menu">
      <li><a href="index.php?p=statistics"><?php _e('Statistics'); ?></a></li> 
      <li><a href="index.php?p=card-statistics"><?php _e('Statistics by cards'); ?></a></li> 
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=categories"><?php _e('Products'); ?></a></li>
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=add-customer"><?php _e('Add customer'); ?></a></li>
      <li><a href="index.php?p=customers"><?php _e('Customers'); ?></a></li>
      <li><a href="index.php?p=cards-discount"><?php _e('Cards discount'); ?></a></li>
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=sales-by-worker"><?php _e('Sales'); ?></a></li>
      <li><a href="index.php?p=sales-by-magazines"><?php _e('Sales by magazines'); ?></a></li> 
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=add-magazine"><?php _e('Add magazine'); ?></a></li> 
      <li><a href="index.php?p=magazines"><?php _e('Magazines'); ?></a></li>
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=workers"><?php _e('Workers'); ?></a></li>
      <li><a href="index.php?p=workers-archive"><?php _e('Workers archive'); ?></a></li>
      <li><a href="index.php?p=add-worker"><?php _e('Add worker'); ?></a></li>
    </ul>

<?php endif; ?>

</div> <!-- #sider -->
