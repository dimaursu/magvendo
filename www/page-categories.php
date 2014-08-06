<?php

$url = "index.php?p=categories";

// Verify actions.
if (isset($_GET['a']) 
    && $_GET['a'] == 'delete' 
    && isset($_GET['id']) 
    && is_numeric($_GET['id']))
  {
      // Remove user.
      remove_category($_GET['id']);
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

<h2><?php _e('Categories'); ?></h2>

<div id="vendors-list">
    <?php $categories = get_categories($page); ?> 
    <h3><a href="index.php?p=add-category"><? _e('Add a new category'); ?></a></h3>
    <table class="ls-table">
       <tr><th><?php _e('Name'); ?></th><th><?php _e('Description'); ?></th><th class="actions"><?php _e('Actions'); ?></th></tr>
       <?php if (!empty($categories)) : ?>
           <?php foreach($categories as $key => $category) : ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td><?php echo $category['name'] ?></b></a></td>
               <td><?php echo $category['description'] ?></td>
               <td class="actions"><a href="index.php?p=edit-category&id=<?php echo $category['id']; ?>"><?php _e('Edit'); ?></a> 
               | <a href="index.php?p=categories&a=delete&id=<?php echo $category['id']; ?>"><?php _e('Delete'); ?></a></td>
            </tr>
           <?php endforeach; ?>
       <?php endif; ?>
    </table>
    <?php $number = categories_number(); ?>
    <?php pagination($page, $number, 10, $url); ?>
</div> <!--- #categories-list -->
