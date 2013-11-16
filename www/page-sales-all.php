<?php

// Verify page variable.
if (isset($_GET['magazine_id']) && isset($_GET['user_id']))
  {
      $url = 'index.php?p=sales-all&magazine_id='
          .$_GET['magazine_id'].'&user_id='.$_GET['user_id'];
  }
else if(!isset($_GET['magazine_id']) && isset($_GET['user_id']))
 {
      $url = 'index.php?p=sales-all&user_id='.$_GET['user_id'];
 }
else if(isset($_GET['magazine_id']) && !isset($_GET['user_id']))
 {
      $url = 'index.php?p=sales-all&magazine_id='.$_GET['magazine_id'];
 }
else
 {
      $url = 'index.php?p=sales-all';
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
  <?php if (isset($_GET['user_id'])) : ?>
      <?php $worker_details = get_user($_GET['user_id']); ?>
      <h3><?php _e('Worker'); ?> : <?php echo $worker_details['name']; ?></h3>
  <?php endif; ?>
  <?php if (isset($_GET['magazine_id'])) : ?>
      <?php $magazine_details = get_magazine($_GET['magazine_id']); ?>
      <h3><?php _e('Magazine'); ?> : <?php echo $magazine_details['name']; ?></h3>
  <?php endif; ?>
  <div class="period">  
        <h3><?php _e('Period'); ?></h3>
        <form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
            <input type="radio" name="last-period"  <?php if($period == 'week') : ?>checked="checked"<?php endif; ?> value="week"><?php _e('Last week'); ?> 
            <input type="radio" name="last-period"  <?php if($period == 'month') : ?>checked="checked"<?php endif; ?> value="month"><?php _e('Last month'); ?>
            <input type="radio" name="last-period"  <?php if($period == 'three-months') : ?>checked="checked"<?php endif; ?> value="three-months"><?php _e('Last 3 months'); ?> <br>
            <p><?php _e('From'); ?><input class="date" type="date" name="date-begin"> <?php _e('To'); ?> <input class="date" type="date" name="date-end"></p>
            <input class="show-button" type="submit" name="show" value="<?php _e('Show'); ?>">
        </form>
  </div> <!-- .period -->

  <div class="sales">
    <p><input class="print-button" type="button" href="#" onClick="window.print(); return false" value="<?php _e('Print');?>"></p>
    <p><b><?php _e('Period'); ?>: <?php echo date("d-m-Y", strtotime($date_from)).' &mdash; '.date("d-m-Y", strtotime($date_to)); ?></b></p>
        <table class="ls-table">
             <tr>
               <th><?php _e('Magazine'); ?></th>    
               <th><?php _e('Worker'); ?></th>   
               <th><?php _e('Product name'); ?></th>
               <th><?php _e('Price, Lei'); ?></th>
               <th><?php _e('Quantity'); ?></th>
               <th><?php _e('Discount'); ?>, %</th>
               <th><?php _e('Sum, Lei'); ?></th>
               <th class="actions"><?php _e('Actions'); ?></th>
             </tr> 
             <?php 
                 if (isset($_GET['magazine_id']) && isset($_GET['user_id']))
                   {
                       $products_sold = get_sales($date_from, $date_to, $_GET['user_id'], $_GET['magazine_id']);
                   }
                 else if(!isset($_GET['magazine_id']) && isset($_GET['user_id']))
                   {
                       $products_sold = get_sales($date_from, $date_to, $_GET['user_id']);
                   }
                 else if(isset($_GET['magazine_id']) && !isset($_GET['user_id']))
                  {
                       $products_sold = get_sales($date_from, $date_to, '', $_GET['magazine_id']);
                  }
                 else
                  {
                       $products_sold = get_sales($date_from, $date_to);
                  }
                $total = 0; 
                $date = '';
                $total_by_date = 0;
                $days = 0;
             ?>

             <?php foreach ($products_sold as $key => $product_sold) : ?>
                 <?php if ($date != $product_sold['date']) : ?>
                     <?php $days++; ?>
                     <?php if($key > 0) : ?> 
                         <tr>
                           <td></td><td><td></td></td><td></td><td></td><td></td>
                           <td class="total_by_date"><?php echo $total_by_date; $total_by_date = 0; ?></td>
                         </tr>
                     <?php endif; ?>
                     <tr class="date"><td><h3><?php $date = $product_sold['date']; echo date("d-m-Y", strtotime($date)); ?></h3></td></tr>
                 <?php endif; ?>
                 <tr>
                     <?php $magazine_details = get_magazine($product_sold['magazine_id']); ?>  
                     <td><b><a href="index.php?p=sales-all&magazine_id=<?php echo $magazine_details['id']; ?>"><?php echo $magazine_details['name']; ?></a></b></td>    
                     <?php $worker_details = get_user($product_sold['user_id']); ?>  
                     <td><b><a href="index.php?p=sales-all&magazine_id=<?php echo $magazine_details['id']; ?>&user_id=<?php echo $worker_details['id']; ?>"><?php echo $worker_details['name']; ?></a></b></td>    
                   <td><?php echo $product_sold['name']; ?></td>
                   <td><?php echo $product_sold['price']; ?></td>
                   <td><?php echo $product_sold['quantity']; ?></td>
                   <td><?php echo $product_sold['discount']; ?></td>
                   <?php $sum = ceil($product_sold['quantity'] * $product_sold['price'] * (1-0.01*$product_sold['discount'])); ?> 
                   <td>
                     <?php echo $sum; ?>
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
                 <?php endforeach; ?>
                 <?php if($total_by_date > 0) : ?>   
                     <tr>
                       <td></td> 
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td class="total_by_date"><?php echo $total_by_date; ?></td>
                     </tr>
                 <?php endif; ?>
                <tr class="total">
                  <td></td><td></td><td></td><td></td><td></td>
                  <td><b><?php _e('Total'); ?>: </b></td>
                  <td><b><?php echo $total; ?></b></td>
                 </tr>
                <tr class="total"><td></td><td></td><td></td><td></td><td></td><td><b><?php _e('Days'); ?>: </b></td><td><b><?php echo $days; ?></b></td></tr>
         </table>

        <p><input class="print-button" type="button" href="#" onclick="window.print(); return false" value="<?php _e('Print');?>"></p>

   </div><!-- #products-sold -->

</div> <!-- #sales-list -->
