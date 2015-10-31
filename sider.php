<div id="sider"> 
<?php if (isset($_SESSION['magsales']['magazine_id'])) : ?>
  <?php if(has_worker_role(SALE)) : ?>
    <h2><?php _e('Sales'); ?></h2>
    <ul>
        <li><a href="index.php?p=sale"><?php _e('Sale'); ?></a></li>
        <li><a href="index.php?p=sales"><?php _e('Sales list'); ?></a></li>
    </ul>
  <?php endif; ?>
  <?php if(has_worker_role(REPARE)) : ?>
    <h2><?php _e('Reparation'); ?></h2>
    <ul>
        <li><a href="index.php?p=add-repared"><?php _e('Add repared'); ?></a></li>
        <li><a href="index.php?p=repared-list"><?php _e('Repared list'); ?></a></li>
    </ul>
  <?php endif; ?>
  <?php if (has_worker_role(FABRICATE)) : ?>
    <h2><?php _e('Fabrication'); ?></h2>
    <ul>
        <li><a href="index.php?p=add-fabricated"><?php _e('Add fabricated'); ?></a></li>
        <li><a href="index.php?p=fabricated-list"><?php _e('Fabricated list'); ?></a></li>
    </ul>
  <?php endif; ?>
  <h2><?php _e('Salary'); ?></h2>

  <?php $salary = get_worker_salary(date('Y-m-d'), date('Y-m-d'), $_SESSION['magsales']['magazine_id'], $_SESSION['magsales']['user_id']); ?>
  <ul>
    <?php if(isset($salary['sale'])) : ?>
        <li><b><?php _e('Sales'); ?>: </b><?php echo $salary['sale']; ?></li>
    <?php endif; ?>
    <?php if(isset($salary['repared'])) : ?>
        <li><b><?php _e('Reparation'); ?>: </b><?php echo $salary['repared']; ?></li>
    <?php endif; ?> 
    <?php if(isset($salary['repared_sales_percent'])) : ?>
        <li><b><?php _e('For repared role (from sales)'); ?>: </b><?php echo $salary['repared_sales_percent']; ?></li>
    <?php endif; ?>
    <?php if(isset($salary['fabricated'])) : ?>
        <li><b><?php _e('Fabrication'); ?>: </b><?php echo $salary['fabricated']; ?></li>
    <?php endif; ?>
    <li><b><?php _e('Total'); ?>: </b><?php echo $salary['total_salary']; ?></li>
  </ul>

<?php endif; ?>

<?php if(user_role() == ADMIN_ROLE) : ?>    
    <h2><?php _e('Admin'); ?></h2>
    <ul id="side-admin-menu">
      <li><a href="index.php?p=salaries"><?php _e('Salaries'); ?></a></li>
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=statistics"><?php _e('Statistics'); ?></a></li> 
      <li><a href="index.php?p=card-statistics"><?php _e('Statistics by cards'); ?></a></li> 
      <li><span class="separator"></span></li>
      <li><a href="index.php?p=add-category"><?php _e('Add a new category'); ?></a></li>
      <li><a href="index.php?p=categories"><?php _e('Categories'); ?></a></li>
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
