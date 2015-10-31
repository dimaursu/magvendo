<?php

// Verify user id.
if (isset($_GET['id']) && is_numeric($_GET['id']) && user_role() == ADMIN_ROLE) 
  {
      $user_id = $_GET['id']; 
  }
else 
  {
      $user_id = $_SESSION['magsales']['user_id'];     
  }


// Verify page variable.
if (isset($_GET['p']) && $_GET['p'] == 'sales')
  {
      $url = 'index.php?p=sales&id='.$user_id;
  }
else 
 {
      $url = 'index.php?id='.$user_id;
 }

//Define default period.
$period = 'month';   

if (isset($_POST['show']))
  {
      if (!empty($_POST['date-begin']) && !empty($_POST['date-end']))
        {
            $period = 'range';
        } 
      else
       {
            $period = $_POST['last-period'];
       }       
  }

// Define today until 23:59:59.
$date_to = date('Y-m-d');  

if ($period == 'week') 
  {
      $date_from = date('Y-m-d', mktime(0, 0, 0, date('m'), date("d") - 7,  date("Y")));
  }
else if ($period == 'month')
  {
      $date_from = date('Y-m-d', mktime(0, 0, 0, date('m') - 1, date("d"),  date("Y")));
  }
else if($period == 'three-months') 
  {
      $date_from = date('Y-m-d', mktime(0, 0, 0, date('m') - 3, date("d"),  date("Y"))); 
  }
else 
 {
      $date_from = date("Y-m-d", strtotime($_POST['date-begin']));
      $date_to = date("Y-m-d", strtotime($_POST['date-end']));
 }

?>

<?php if (isset($_POST['delete'])): /* Verify delete variable. */ ?>
    <?php $result = delete_sale($_POST['sold_id']); ?>
    <?php if (!$result) : ?>
        <script type="text/javascript">
          $(function() {
          $.jnotify('The sale couldn\'t be deleted.', 'error', {timeout: 3});
          } );
        </script>
    <?php else : ?> 
        <script type="text/javascript">
          $(function() {
          $.jnotify('Sale was deleted successfully', 'success', {timeout: 3});
          } );
        </script>
    <?php endif; ?>
<?php endif; ?>

<div id="sales-list">
  <h2><?php _e("Sales list"); ?></h2>  
  <?php if ($user_id != $_SESSION['magsales']['user_id']) : /* Don't show information for the current logged user */ ?>
      <?php $worker_detals = get_user($user_id); ?>
      <h3><?php _e('Worker'); ?> : <a href="index.php?p=user&id=<?php echo $user_id; ?>"><?php echo $worker_detals['name'] ?></a></h3>
  <?php endif; ?>
  <div class="period">  
        <h3><?php _e('Period'); ?></h3>
        <form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
            <input type="radio" name="last-period"  <?php if($period == 'week') : ?>checked="checked"<?php endif; ?> value="week"><?php _e('Last week'); ?> 
            <input type="radio" name="last-period"  <?php if($period == 'month') : ?>checked="checked"<?php endif; ?> value="month"><?php _e('Last month'); ?>
            <input type="radio" name="last-period"  <?php if($period == 'three-months') : ?>checked="checked"<?php endif; ?> value="three-months"><?php _e('Last 3 months'); ?> <br>
            <p><?php _e('From'); ?><input class="date" type="text" name="date-begin"> <?php _e('To'); ?> <input class="date" type="text" name="date-end"></p>
            <input class="show-button" type="submit" name="show" value="<?php _e('Show'); ?>">
        </form>
  </div> <!-- .period -->

  <div class="sales">
    <p><input class="print-button" type="button" href="#" onClick="window.print(); return false" value="<?php _e('Print');?>"></p>
    <p><b><?php _e('Period'); ?>: <?php echo date("d-m-Y", strtotime($date_from)).' &mdash; '.date("d-m-Y", strtotime($date_to)); ?></b></p>
        <table class="ls-table">
             <tr>
               <th><?php _e('Product name'); ?></th>
               <th><?php _e('Price, Lei'); ?></th>
               <th><?php _e('Quantity'); ?></th>
               <th><?php _e('Discount'); ?>, %</th>
               <th><?php _e('Sum, Lei'); ?></th>
               <th><?php _e('Salary, Lei'); ?></th> 
               <th class="actions"><?php _e('Actions'); ?></th>
             </tr>
 
             <?php 
                $products_sold = get_sales($date_from, $date_to, $user_id, $_SESSION['magsales']['magazine_id']);
                $total = 0;
                $total_by_date = 0;
                $date = '';
                $salary_total = 0;
                $salary_by_date = 0;
                $days = 0;
             ?>

             <?php foreach ($products_sold as $key => $product_sold) : ?>
                 <?php if ($date != $product_sold['date']) : ?>
                     <?php $days++; ?>
                     <?php if($key > 0) : ?> 
                         <tr>
                           <td></td><td><td></td></td><td></td>
                           <td class="total_by_date"><?php echo $total_by_date; ?></td>
                           <td><?php echo floor($salary_by_date); $salary_by_date = 0; ?></td>
                           <td></td> 
                         </tr>
                     <?php endif; ?>
                     <tr class="date"><td><h3><?php $date = $product_sold['date']; echo date("d-m-Y", strtotime($date)); ?></h3></td></tr>
                 <?php endif; ?>
                 <tr>
                   <td><?php echo $product_sold['name']; ?></td>
                   <td><?php echo $product_sold['price']; ?></td>
                   <td><?php echo $product_sold['quantity']; ?></td>
                   <td><?php echo $product_sold['discount']; ?></td>
                   <?php $sum = ceil($product_sold['quantity'] * $product_sold['price'] * (1-0.01*$product_sold['discount'])); ?> 
                   <td>
                     <?php echo $sum; ?>
                   </td>
                   <td>
                       <?php if($product_sold['salary_percent'] == 0) : ?>
		           <?php echo $salary = floor($sum * 0.1); ?>
		       <?php else :?>
                           <?php echo $salary = floor($sum * 0.01 * $product_sold['salary_percent']); ?>
		           (<?php echo $product_sold['salary_percent']; ?> %)
		       <?php endif; ?>
                   </td>
                   <td class="actions">
                     <form enctype="multipart/form-data"  action="<?php echo $url; ?>" method="post"> 
                       <input class="delete" type="submit" name="delete" value = "<?php _e('Delete'); ?>"/>
                       <input type="hidden" name="sold_id" value="<?php echo $product_sold['id']; ?>"/> 
                     </form>
                   </td>
                 </tr>
                 <?php $total += $sum; ?> 
                 <?php $total_by_date += $sum; ?> 
                 <?php $salary_by_date += $salary; ?> 
                 <?php $salary_total += $salary; ?> 
                 <?php endforeach; ?>
                 <?php if($total_by_date > 0) : ?>   
                     <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td class="total_by_date"><?php echo $total_by_date; ?></td>
                       <td><?php echo floor($salary_by_date); $salary_by_date = 0; ?></td>
                       <td></td>
                     </tr>
                 <?php endif; ?>
                <tr class="total">
                  <td></td><td></td><td></td>
                  <td><b><?php _e('Total'); ?>: </b></td>
                  <td><b><?php echo $total; ?></b></td>
                  <td><?php echo floor($salary_total); ?></td>
                 </tr>
                <tr class="total"><td></td><td></td><td></td><td><b><?php _e('Days'); ?>: </b></td><td></td><td><b><?php echo $days; ?></b></td></tr>
         </table>

        <p><input class="print-button" type="button" href="#" onclick="window.print(); return false" value="<?php _e('Print');?>"></p>

   </div><!-- #products-sold -->

</div> <!-- #sales-list -->
