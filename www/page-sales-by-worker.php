<?php

// Verify page variable.
if (isset($_GET['p']) && $_GET['p'] == 'sales-by-worker')
  {
      $url = 'index.php?p=sales-by-worker';
  }
else 
 {
      $url = 'index.php';
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
               <th><?php _e('Date'); ?></th>
               <th><?php _e('Sales'); ?></th>
               <th><?php _e('Reparation'); ?></th>
               <th><?php _e('Total'); ?></th>
               <th><?php _e('Sale worker'); ?></th>
             </tr> 
             <?php 
                $total_sales = 0;
                $total_repared = 0;
                $total = 0; 
             ?>
             <?php for ($date = $date_to; strtotime($date) >= strtotime($date_from); $date = date('Y-m-d', strtotime(' -1 day', strtotime($date)))) : ?>
                 <?php $sum_by_date = get_sum_by_date($date, $_SESSION['magazine_id']); ?>
               <?php if($sum_by_date['sales_sum']+$sum_by_date['repared_sum'] != 0) : ?>  
                 <?php $worker = get_user($sum_by_date['user_id']); ?>
                 <tr>
                   <td><?php echo $date; ?></td>
                   <td><?php echo ceil($sum_by_date['sales_sum']); ?></td>
                   <td><?php echo ceil($sum_by_date['repared_sum']); ?></td>
                   <td><?php echo ceil($sum_by_date['repared_sum']) + ceil($sum_by_date['sales_sum']); ?></td>
                   <?php  $total_sales += ceil($sum_by_date['sales_sum']); ?>
                   <?php  $total_repared +=  ceil($sum_by_date['repared_sum']); ?>
                   <?php  $total += ceil($sum_by_date['sales_sum']) + ceil($sum_by_date['repared_sum']); ?>
                   <td><?php echo $worker['name']; ?></td>
               <?php endif; ?>
             <?php endfor; ?>
                 </tr>
                <tr class="total">
                  <td><b><?php _e('Total'); ?>: </b></td>
                  <td><b><?php echo $total_sales; ?></b></td>
                  <td><b><?php echo $total_repared; ?></b></td>
                  <td><b><?php echo $total; ?></b></td>
                 </tr>
         </table>

        <p><input class="print-button" type="button" href="#" onclick="window.print(); return false" value="<?php _e('Print');?>"></p>

   </div><!-- #products-sold -->

</div> <!-- #sales-list -->
