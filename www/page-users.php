<?php 

$url = "index.php?p=users";

// Verify actions.
if (isset($_GET['a']) 
    && $_GET['a'] == 'delete' 
    && isset($_GET['id']) 
    && is_numeric($_GET['id']))
  {
      // Remove user.
      remove_user($_GET['id']);
  }

if (isset($_GET['page']) && is_numeric($_GET['page']))
  {
      $page = $_GET['page'];
  }
else
  {
      $page = 1;
  } 

$conditions = array();

// Verify search post variable.
if (!empty($_POST['search']))
  {
      $conditions['search'] = $_POST['search-input'];
      $url .= "&s=".$_POST['search-input'];
  } 
else if (!empty($_GET['s']))
  {
      $conditions['search'] = $_GET['s'];
      $url .= "&s=".$_GET['s'];
  }

?>

<h2><?php _e('Users list'); ?></h2>

<div id="users-list">
    <p><form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
         <input type="search" name="search-input" autofocus="autofocus" placeholder="<?php _e('Search by username or name'); ?>" value="" /> 
         <input type="submit" class="search-button" name="search" value="<?php _e('Search'); ?>" /> 
    </form></p>
    <?php $users = get_users($page, $conditions); ?> 
    <table class="ls-table">
       <tr><th><? _e('Name'); ?></th><th><?php _e('Username'); ?></th><th><? _e('Phone'); ?></th><th><? _e('Role'); ?></th><th class="actions"><? _e('Actions'); ?></th></tr>
       <?php if (!empty($users)) : ?>
           <?php foreach($users as $key => $user) : ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td><a href="index.php?p=user&id=<?php echo $user['id']; ?>"><?php echo $user['name'] ?></a></td>
               <td><?php echo $user['username']; ?></td>
               <td><?php echo $user['phone'] ?></td>
               <td><?php if ($user['role'] != 1): ?>User<?php else : ?>Admin<?php endif; ?>
               <td class="actions">
                   <a href="index.php?p=edit-user&id=<?php echo $user['id']; ?>"><?php _e('Edit'); ?></a>
                   | <a href="index.php?p=users&a=delete&id=<?php echo $user['id']; ?>"><?php _e('Delete'); ?></a>
               </td>
            </tr>
           <?php endforeach; ?>
       <?php endif; ?>
    </table>
    <?php $number = users_number($conditions); ?>
    <?php pagination($page, $number, 10, $url); ?>
</div> <!--- #users-list -->
