<?php if (user_role() != 1) : ?>
    <p><?php _e('You cannot access this page.'); ?></p>
<?php else : ?>
    <h2><?php _e('Add magazine'); ?></h2>

    <?php if (isset($_POST['add'])) : ?>
        <?php $error = mags_save_magazine(); ?>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif(isset($error)) : ?>
        <p class="success"><?php _e('The magazine has been added successfully.'); ?></p>
    <?php endif; ?>

    <form class="input-form" enctype="multipart/form-data" action="index.php?p=add-magazine" method="post">
      <table>
        <tr>
          <td class="first">
            <?php _e('Name'); ?>:<sup>*</sup>
          </td>
          <td>
            <input type="text" name="name" autofocus="autofocus" 
                value="<?php if(!empty($error) && !empty($_POST['username']) ) : ?><?php echo $_POST['username']; ?><?php endif; ?>" />
          </td>
        </tr>
      <tr> 
          <td class="first">
              <?php _e('More information'); ?>:
          </td>
          <td><textarea type="text" name="description"><?php if(!empty($error) && !empty($_POST['description']) ) : ?><?php echo $_POST['description']; ?><?php endif; ?></textarea>
          </td>
      </tr>
      <tr>
      <td></td><td><input class="submit" type="submit" name="add" value="<?php _e('Save'); ?>" /></td>
      </tr>
      </table>
    </form>
<?php endif; /* if (user_role() != 1) */ ?> 
