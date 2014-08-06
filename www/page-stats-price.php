<?php

$product_id = (empty($_GET['product']) || !is_numeric($_GET['product'])) ? 0 : $_GET['product'];

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
      $url = 'index.php?p=stats-price&product=' . $product_id;
  }
else
  {
      $url = 'index.php?p=stats-price&product=' . $product_id . '&'. implode("&", $conditions);
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

<?php $product = get_category($product_id); ?>

<h2><a href="index.php?p=statistics"><?php _e('Statistics'); ?></a>: <?php _e('Price'); ?> (<?php echo $product['name']; ?>)</h2>

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
<?php
$args = array();
if(!empty($_GET['user'])) $args['user'] = $_GET['user'];
if(!empty($_GET['magazine'])) $args['magazine'] = $_GET['magazine'];
$args['from'] = $date_from;
$args['to']   = $date_to;
$products = mags_product_sales_by_price($product_id, $args);
?>
<table class="ls-table">
<tr>
  <th><?php _e('Price'); ?></th>
  <th><?php _e('Percent'); ?>, % </th>
  <th><?php _e('Quantity'); ?></th>
  <th><?php _e('Sum, lei'); ?></th>
</tr>
 <?php foreach($products as $product) : ?>
<tr>
<td><b><?php echo $product['price']; ?></b></td>
<td><b><?php echo round($product['percent'], 2, PHP_ROUND_HALF_DOWN); ?></b></td>
<td><?php echo $product['quantity']; ?></td>
<td><?php echo $product['totprice']; ?></td>
 </tr>
 <?php endforeach; ?>
</table>
