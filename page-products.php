<?php

$url = "index.php?p=categories";

// Verify actions.
if (isset($_GET['a']) 
    && $_GET['a'] == 'delete' 
    && isset($_GET['id']) 
    && is_numeric($_GET['id']))
  {
      // Remove user.
      magv_remove_product($_GET['id']);
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

<h2><?php _e('Products'); ?></h2>

<div id="vendors-list">
    <?php $products = magv_get_products($page); ?> 
    <h3><a href="index.php?p=add-product"><?php _e('Add product'); ?></a></h3>
    <table class="ls-table">
       <tr><th><?php _e('Name'); ?></th>
       <th><?php _e('Description'); ?>
       </th><th class="actions"><?php _e('Actions'); ?></th></tr>
       <?php if (!empty($products)) : ?>
           <?php foreach($products as $key => $product) : ?>
            <tr <?php if ($key % 2 == 0) : ?>class="even"<?php endif; ?>>
               <td><?php echo $product['name'] ?></b></a></td>
               <td><?php echo $product['description'] ?></td>
               <td class="actions"><a href="index.php?p=edit-product&id=<?php echo $product['id']; ?>"><?php _e('Edit'); ?></a> 
               | <a href="index.php?p=products&a=delete&id=<?php echo $product['id']; ?>"><?php _e('Delete'); ?></a></td>
            </tr>
           <?php endforeach; ?>
       <?php endif; ?>
    </table>
    <?php $number = magv_products_number(); ?>
    <?php pagination($page, $number, 10, $url); ?>
</div> <!--- #categories-list -->
