<?php

$url = "index.php?p=workers";

if (isset($_GET['page']) && is_numeric($_GET['page']))
  {
      $page = $_GET['page'];
  }
else
  {
      $page = 1;
  } 
?>

<h2><?php _e('Workers'); ?></h2>

<div>
    <?php $users = get_users($page); ?> 
    <h3><a href="index.php?p=add-workere"><? _e('Add worker'); ?></a></h3>
    <table class="ls-table">
       <tr>
         <th><?php _e('Name'); ?></th>
         <th class="actions"><?php _e('Actions'); ?></th>
      </tr>
<?php if (!empty($users)) : ?>
           <?php foreach($users as $key => $user) : ?>
            <?php if($user['status']) continue; ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td><b><?php echo $user['name'] ?></b></a></b></td>
               <td class="actions"><a href="index.php?p=edit-worker&id=<?php echo $user['id']; ?>"><?php _e('Edit'); ?></a> 
            </tr>
           <?php endforeach; ?>
       <?php endif; ?>
    </table>
</div>

<p><a href="index.php?p=workers-archive"><?php _e('Workers archive'); ?></a></p>

