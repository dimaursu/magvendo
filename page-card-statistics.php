<?php

$url = "index.php?p=card-statistics";

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
} 

//Define default period.
$period = 'year';

if (isset($_POST['show'])) {
    if (!empty($_POST['date-begin']) && !empty($_POST['date-end'])) {
        $period = 'range';
    } else {
        $period = $_POST['last-period'];
    }
}

$date_to = date('Y-m-d');

if ($period == 'three-months') {
    $date_from = date('Y-m-d', mktime(0, 0, 0, date('m') - 3, date("d"),  date("Y")));
} else if ($period == 'six-months') {
    $date_from = date('Y-m-d', mktime(0, 0, 0, date('m') - 6, date("d"),  date("Y")));
} else if($period == 'year') {
    $date_from = date('Y-m-d', mktime(0, 0, 0, date('m'), date("d"),  date("Y") - 1)); 
} else {
    $date_from = date("Y-m-d", strtotime($_POST['date-begin']));
    $date_to = date("Y-m-d", strtotime($_POST['date-end']));
}

?>


<h2><?php _e('Statistics'); ?> [<?php _e('Карточка'); ?>]</h2>

  <div class="period">  
        <h3><?php _e('Period'); ?></h3>
        <form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
            <input type="radio" name="last-period"  <?php if($period == 'three-months') : ?>checked="checked"<?php endif; ?> value="three-months"><?php _e('Last 3 months'); ?> 
            <input type="radio" name="last-period"  <?php if($period == 'six-months') : ?>checked="checked"<?php endif; ?> value="six-months"><?php _e('Six months'); ?>
            <input type="radio" name="last-period"  <?php if($period == 'year') : ?>checked="checked"<?php endif; ?> value="year"><?php _e('Last year'); ?> <br>
            <p><?php _e('From'); ?><input class="date" type="text" name="date-begin"> <?php _e('To'); ?> <input class="date" type="text" name="date-end"></p>
            <input class="show-button" type="submit" name="show" value="<?php _e('Show'); ?>">
        </form>
  </div> <!-- .period -->

<p><b><?php _e('Period'); ?>:</b> <?php echo date("d-m-Y", strtotime($date_from)).' &mdash; '.date("d-m-Y", strtotime($date_to)); ?><br>

<?php
$args = array();
$args['from'] = $date_from;
$args['to']   = $date_to;
$cards = mag_cards_sales($date_from, $date_to);
?>

<table class="ls-table">
<tr>
  <th><?php _e('Card number'); ?></th>
  <th><?php _e('Customer'); ?></th>
  <th><?php _e('Phone'); ?></th>
  <th><?php _e('Sum, lei'); ?></th>
</tr>
 <?php foreach($cards as $card) : ?>
     <tr>
       <td><?php echo $card['card_number']; ?></td>
       <td><b><a href="index.php?p=customer&id=<?php echo $card['customer_id']?>">
                <?php echo $card['customer_name']; ?>
            </a></b>
        </td>
       <td><?php echo $card['phone']; ?></td>
       <td><?php echo ceil($card['sales']); ?></td>
     </tr>
 <?php endforeach; ?>
</table>