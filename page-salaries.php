<?php 

// Verify page variable.
if (isset($_GET['p']) && $_GET['p'] == 'salaries')
  {
      $url = 'index.php?p=salaries';
  }
else 
 {
      $url = 'index.php?p=home';
 }


// For the current month.
$date_from = date('Y-m-d', mktime(0, 0, 0, date('m'), 1,  date("Y")));
$date_to = date('Y-m-d'); 

if (isset($_POST['show']))
  {
      if (!empty($_POST['date-begin']) && !empty($_POST['date-end']))
        {
            $date_from = date("Y-m-d", strtotime($_POST['date-begin']));
            $date_to = date("Y-m-d", strtotime($_POST['date-end']));
        } 
}

?>

<h2><?php _e('Salaries'); ?></h2>

  <div class="period">  
        <h3><?php _e('Period'); ?></h3>
        <form enctype="multipart/form-data" action="<?php $url; ?>" method="post">
            <p><?php _e('From'); ?><input class="date" type="text" name="date-begin"> <?php _e('To'); ?> <input class="date" type="text" name="date-end"></p>
            <input class="show-button" type="submit" name="show" value="<?php _e('Show'); ?>">
        </form>
  </div> <!-- .period -->

<div id="workes-list">
    <!--p><form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
         <input type="search" name="search-input" autofocus="autofocus" placeholder="<?php _e('Search by workername or name'); ?>" value="" /> 
         <input type="submit" class="search-button" name="search" value="<?php _e('Search'); ?>" /> 
    </form></p-->
    <?php $workers = get_workes($_SESSION['magvendo']['magazine_id']); ?> 
    <p><b><?php _e('Period'); ?>: <?php echo date("d-m-Y", strtotime($date_from)).' &mdash; '.date("d-m-Y", strtotime($date_to)); ?></b></p>
    <table class="ls-table">
       <tr>
         <th><? _e('Name'); ?></th>
         <th></th>
         <th><? _e('Worked days'); ?></th>
       </tr>
       <?php if (!empty($workers)) : ?>
           <?php foreach($workers as $key => $worker) : ?>
           <?php if ($worker['status']) : ?>
               <?php continue; ?>
           <?php endif; ?>
           <?php $worker_roles = get_worker_roles($worker['id'], $_SESSION['magvendo']['magazine_id']); ?>
         <?php if (!empty($worker_roles)) : ?>      
           <?php  $worker['worked_days'] = worked_days($worker['id'], $_SESSION['magvendo']['magazine_id'], $date_from, $date_to); ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td><b><a href="index.php?p=edit-worker&id=<?php echo $worker['id']; ?>"><?php echo $worker['name']; ?></a></b></td> 
               <td>
                 <?php $worker_salary = get_worker_salary($date_from, $date_to, $_SESSION['magvendo']['magazine_id'], $worker['id']); ?> 
                 <table class="worker-roles">
                   <tr>  
                     <th><? _e('Worker role'); ?></th>
                     <th><?php _e('Salary, lei'); ?></th>
                     <th><?php _e('Sles procent'); ?></th>
                     <th><?php _e('Total'); ?></th>
                     <th><?php _e('For worked days'); ?></th>
                   </tr>
                   <?php foreach ($worker_roles as $worker_role) : ?> 
                       <tr>
                         <td>
                           <a href="index.php?p=<?php echo $work_roles_page_url[$worker_role['work_role']]; ?>&id=<?php echo $worker['id']; ?>">
                             <?php echo $work_roles[$worker_role['work_role']]; ?>
                           </a>
                         </td>
                         <td>
                           <?php if ($worker_role['work_role'] == SALE) : ?>
                               <?php echo $worker_salary['sale']; ?>
                           <?php endif; ?>
                           <?php if ($worker_role['work_role'] == REPARE) : ?>
                               <?php echo $worker_salary['repared']; ?>
                           <?php endif; ?>                            
                           <?php if ($worker_role['work_role'] == FABRICATE) : ?>
                               <?php echo $worker_salary['fabricated']; ?>
                           <?php endif; ?>                            
                         </td>
                         <td>
                           <?php if ($worker_role['work_role'] == REPARE) : ?>
                               <?php echo $worker_salary['repared_sales_percent']; ?>
                           <?php endif; ?>
                         </td>
                         <td> 
                           <?php if ($worker_role['work_role'] == SALE) : ?>
                               <?php echo $worker_salary['sale']; ?>
                           <?php elseif ($worker_role['work_role'] == REPARE) : ?>
                               <?php echo $worker_salary['repared'] + $worker_salary['repared_sales_percent']; ?>
                           <?php elseif ($worker_role['work_role'] == FABRICATE) : ?>
                               <?php echo $worker_salary['fabricated']; ?> 
                           <?php endif; ?>                             
                         <td>
                       </tr>
                   <?php endforeach; ?>
                   <tr><td></td><td></td><td><b><?php _e('Total'); ?></b></td><td><b><?php echo $worker_salary['total_salary']; ?></b></td><td><b><?php echo $worker['worked_days']*65; ?></b></td></tr>
                 </table>
               </td>
               <td>
                 <?php echo $worker['worked_days']; ?>
               </td>
            </tr>
            <?php endif; ?>
           <?php endforeach; ?>
       <?php endif; /* if (!empty($worker_roles)) */?>
    </table>
    <!--?php $number = workers_number($conditions); ?-->
    <!--?php pagination($page, $number, 10, $url); ?-->
</div> <!--- #workers-list -->
