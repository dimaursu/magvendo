<?php 

$url = "index.php?p=customers";

if (isset($_GET['a']) 
    && $_GET['a'] == 'delete' 
    && isset($_GET['id']) 
    && is_numeric($_GET['id'])
) {
    mag_remove_customer($_GET['id']);
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
} 

$conditions = array();

if (!empty($_POST['search'])) {
    $conditions['search'] = $_POST['search-input'];
    $url .= "&s=" . $_POST['search-input'];
} 
else if (!empty($_GET['s'])) {
    $conditions['search'] = $_GET['s'];
    $url .= "&s=".$_GET['s'];
}

?>

<h2><?php _e('Customers'); ?></h2>

<div id="customers-list">
    <p><form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
         <input type="search" name="search-input" autofocus="autofocus" placeholder="<?php _e('Card, name, phone'); ?>" value="" /> 
         <input type="submit" class="search-button" name="search" value="<?php _e('Search'); ?>" /> 
    </form></p>
  <?php $customers = mag_get_customers($page, $conditions, 20); ?> 
    <table class="ls-table">
       <tr>
         <th><?php _e('Name'); ?></th>
         <th><?php _e('Phone'); ?></th>
         <th><?php _e('Birthday'); ?></th>
         <th><?php _e('Sum'); ?></th>
         <th class="actions"><?php _e('Actions'); ?></th>
       </tr>
       <?php if (!empty($customers)) : ?>
           <?php foreach($customers as $key => $customer) : ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td>
                   <a href="index.php?p=customer&id=<?php echo $customer['id']; ?>"><?php echo $customer['name'] ?></a>
               </td>
               <td>
                   <?php if (!empty($customer['phone'])) : ?>
		       <?php echo $customer['phone']; ?>
		   <?php endif; ?>
               </td>
               <td>
                   <?php if (!empty($customer['birthday'])) : ?>
		       <?php echo date("d-m-Y", strtotime($customer['birthday'])); ?>
		   <?php endif; ?>
               </td>
               <td> <?php echo ceil($customer['sales']); ?></td>
               <td class="actions">
                   <a href="index.php?p=edit-customer&id=<?php echo $customer['id']; ?>"><?php _e('Edit'); ?></a>
                   | <a href="index.php?p=customers&a=delete&id=<?php echo $customer['id']; ?>"><?php _e('Delete'); ?></a>
               </td>
            </tr>
           <?php endforeach; ?>
       <?php endif; ?>
    </table>
    <?php $number = mag_customers_number($conditions); ?>
    <?php pagination($page, $number, 20, $url); ?>
</div> <!--- #users-list -->
