<h2><?php _e('Edit product'); ?></h2>

<?php if (!isset($_GET['id']) || !is_numeric($_GET['id'])) : ?>
    <p><?php _e('The product dosen\'t exit.'); ?></p>
<?php else: ?>
    <?php if (isset($_POST['update'])) : ?>
        <?php $error = magv_save_product(); ?>
    <?php endif; ?>
    <?php $category = magv_get_product($_GET['id']); ?>
    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif(isset($error)) : ?>
        <p class="success"><?php _e('The product has been updated succesfully.'); ?></p>
    <?php endif; ?> 

    <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-product&id=<?php echo $_GET['id']; ?>" method="post">
      <table>
        <tr>
          <td class="first">
            <?php _e('Name'); ?><sup>*</sup>:
          </td>
          <td>
            <?php if(!empty($error) && !empty($_POST['name']) ) : ?>
                <?php $name = $_POST['name']; ?>
            <?php else :?>
                <?php $name = $category['name']; ?>
            <?php endif; ?>
            <input type="text" name="name" autofocus="autofocus" 
              value="<?php echo $name; ?>" />
          </td>
      </tr>
      <tr>
          <td class="first">
            <?php _e('Description'); ?>:
          </td>
          <td>
            <?php if(!empty($error) && !empty($_POST['quantity']) ) : ?>
                <?php $decription = $_POST['description']; ?>
            <?php else :?>
                <?php $description = $category['description']; ?>
            <?php endif; ?>
            <textarea type="text" name="description"><?php echo $description; ?></textarea>
          </td>
      </tr>
        <tr>
          <td></td>
          <td>
            <input class="submit" type="submit" name="update" 
                value="<?php _e('Save'); ?>" />
          </td>
        </tr>
      </table>
    </form>
<?php endif; /* if (!isset($_GET['id']) && !is_numeric($_GET['id'])) */?>
