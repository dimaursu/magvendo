<?php if (user_role() != 1) : ?>
    <p><?php _e('You cannot access this page.'); ?></p>
<?php else : ?>
    <h2><?php _e('Add customer'); ?></h2>

    <?php if (isset($_POST['add'])) : ?>
        <?php $error = mag_save_customer(); ?>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif(isset($error)) : ?>
        <p class="success"><?php _e('The customer has been added successfully.'); ?></p>
    <?php endif; ?>

    <form class="input-form" enctype="multipart/form-data" action="index.php?p=add-customer" method="post">
      <table>
         <tr>
          <td class="first">
            <?php _e('Name'); ?>:<sup>*</sup>
          </td>
          <td>
            <input type="text" name="name"  
                value="<?php if(!empty($error) && !empty($_POST['name']) ) : ?><?php echo $_POST['name']; ?><?php endif; ?>" />
          </td>
        </tr>
        <tr>
          <td class="first">
            <?php _e('Card'); ?>:<sup>*</sup>
          </td>
          <td>
            <input type="number" name="card" value="" />
          </td>
        </tr>
        <tr>
          <td class="first">
            <?php _e('Phone'); ?>:
          </td>
          <td>
            <input type="tel" name="phone" value="" />
          </td>
        </tr>
        <tr>
          <td class="first">
            <?php _e('Birthday'); ?>:
          </td>
          <td>
            <input type="text" name="birthday" value="" placeholder="<?php _e('dd-mm-yyyy, for example, 09-05-1984'); ?>" />
          </td>
        </tr>
        <tr>
          <td class="first">
            <?php _e('Email'); ?>:
          </td>
          <td>
            <input type="email" name="email" value="" />
          </td>
        </tr>
      <tr>
      <td></td><td><input class="submit" type="submit" name="add" value="<?php _e('Save'); ?>" /></td>
      </tr>
      </table>
    </form>
<?php endif; /* if (user_role() != 1) */ ?> 
