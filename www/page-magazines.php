<?php

$url = "index.php?p=magazines";

if (isset($_GET['a']) 
    && $_GET['a'] == 'delete' 
    && isset($_GET['id']) 
    && is_numeric($_GET['id']))
  {
      remove_magazine($_GET['id']);
  }

if (isset($_GET['page']) && is_numeric($_GET['page']))
  {
      $page = $_GET['page'];
  }
else
  {
      $page = 1;
  } 
?>

<h2><?php _e('Magazines'); ?></h2>

<div>
    <?php $magazines = get_magazines($page); ?> 
    <h3><a href="index.php?p=add-magazine"><? _e('Add magazine'); ?></a></h3>
    <table class="ls-table">
       <tr>
         <th><?php _e('Name'); ?></th>
         <th><?php _e('Workers'); ?></th>
         <th><?php _e('Description'); ?></th>
         <th class="actions"><?php _e('Actions'); ?></th>
      </tr>
<?php if (!empty($magazines)) : ?>
           <?php foreach($magazines as $key => $magazine) : ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td><b><?php echo $magazine['name'] ?></b></a></b></td>
               <?php $workers = get_workers($magazine['id']); ?>
               <td> 
                 <ul>
                   <?php foreach($workers as $worker) : ?>
                       <?php if ($worker['status']) : ?>
                       <?php continue; ?>
                       <?php endif; ?>
                       <li><a href="index.php?p=edit-worker&id=<?php echo $worker['id']?>"><?php echo $worker['name']; ?></a></li>
                   <?php endforeach; ?>
                 </ul>
               </td>
               <td><?php echo $magazine['description'] ?></td>
               <td class="actions"><a href="index.php?p=edit-magazine&id=<?php echo $magazine['id']; ?>"><?php _e('Edit'); ?></a> 
               | <a href="index.php?p=magazines&a=delete&id=<?php echo $magazine['id']; ?>"><?php _e('Delete'); ?></a></td>
            </tr>
           <?php endforeach; ?>
       <?php endif; ?>
    </table>
    <?php $number = magazines_number(); ?>
    <?php pagination($page, $number, 10, $url); ?>
</div>