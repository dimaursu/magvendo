<?php

if (isset($_GET['user']))
  {
      $conditions[] = "user=" . $_GET['user'];
  }

if (isset($_GET['magazine']))
  {
      $conditions[] = "magazine=" . $_GET['user'];
  }

if (empty($conditions))
  {
      $url = 'index.php?p=statistics';
  }
else
  {
      $url = 'index.php?p=statistics&' . implode("&", $conditions);
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


<h2><?php _e('Statistics'); ?></h2>

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

<p><b><?php _e('Period'); ?>:</b> <?php echo date("d-m-Y", strtotime($date_from)).' &mdash; '.date("d-m-Y", strtotime($date_to)); ?><br>
<?php if (!empty($_GET['magazine'])) : ?>
<b><?php _e('Magazine'); ?>:</b> Atrium<br>
<?php endif;?>
<?php if (!empty($_GET['user'])) : ?>
<b><?php _e('Workwer'); ?>:</b> Iurie<br>
<?php endif;?></p>
<?php
$args = array();
/*if(!empty($_GET['user'])) $args['user_id'] = $_GET['user'];
  if(!empty($_GET['magazine'])) $args['magazine_id'] = $_GET['magazine'];*/
$args['from'] = $date_from;
$args['to']   = $date_to;
$products = mags_sales_by_products($args);
?>
<table class="ls-table">
<tr>
  <th><?php _e('Name'); ?></th>
  <th><?php _e('Percent'); ?>, % </th>
  <th><?php _e('Quantity'); ?></th>
  <th><?php _e('Sum, lei'); ?></th>
</tr>
 <?php foreach($products as $product) : ?>
<tr>
<td><b><a href="index.php?p=stats-price&product=<?php echo $product['id']?>"><?php echo $product['name']; ?></a></a></td>
<td><b><?php echo round($product['percent'], 2, PHP_ROUND_HALF_DOWN); ?></b></td>
<td><?php echo $product['quantity']; ?></td>
<td><?php echo $product['totprice']; ?></td>
 </tr>
 <?php endforeach; ?>
</table>

<br><br>

<!--div id="statistics-graphs" style="width: 90%; height: 500px;"></div-->
