<div id="sider"> 
<?php if (isset($_SESSION['magsales']['magazine_id'])) : ?>
  <?php if(has_worker_role(SALE)) : ?>
    <ul>
        <li><a href="index.php?p=sale"><?php _e('Sale'); ?></a></li>
        <li><a href="index.php?p=sales"><?php _e('Sales list'); ?></a></li>
	<li><span class="separator"></span></li>
	<li><a href="index.php?p=products"><?php _e('Products'); ?></a></li>
	<li><span class="separator"></span></li>
	 <li><a href="index.php?p=customers"><?php _e('Customers'); ?></a></li>
      <li><a href="index.php?p=add-customer"><?php _e('Add customer'); ?></a></li>
      <li><span class="separator"></span></li>      
      <li><a href="index.php?p=statistics"><?php _e('Statistics'); ?></a></li> 
    </ul>
  <?php endif; ?>
<?php endif; ?>

</div> <!-- #sider -->
