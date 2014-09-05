<?php if (user_role() != 1) : ?>
    <p><?php _e('You cannot access this page.'); ?></p>
<?php else : ?>
    <h2><?php _e('Edit'); ?></h2>

    <?php if (!isset($_GET['id']) || !is_numeric($_GET['id'])) : ?>
        <p><?php _e('The magazine doesn\'t exit.'); ?></p>
    <?php else: ?>
        <?php if (isset($_POST['update'])) : ?>
            <?php $error = mags_save_magazine(); ?>
        <?php endif; ?>
        <?php $magazine = get_magazine($_GET['id']); ?>
        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif(isset($error)) : ?>
            <p class="success"><?php _e('The magazine has been updated succesfully.'); ?></p>
        <?php endif; ?>

        <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-magazine&id=<?php echo $_GET['id']; ?>" method="post">
          <table>
            <tr>
              <td class="first">
                <?php _e('Name'); ?>:<sup>*</sup>
              </td>
              <td>
                <input type="text" name="name"  
                    value="<?php if(!empty($error) && !empty($_POST['name']) ) : ?><?php echo $_POST['name']; ?><?php else: ?><?php echo $magazine['name']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('More information'); ?>:
              </td>
              <td><textarea type="text" name="description"><?php if(!empty($error) && !empty($_POST['description']) ) : ?><?php echo $_POST['description']; ?><?php else: ?><?php echo $magazine['description']; ?><?php endif; ?></textarea>
              </td>
            </tr>
            <tr>
              <td></td><td><input class="submit" type="submit" name="update" value="<?php _e('Save'); ?>" /></td>
            </tr>
          </table>
        </form>
    <?php endif; /* if (!isset($_GET['id']) || !is_numeric($_GET['id'])) */ ?>
<?php endif; /* if (user_role() != 1) */ ?> 
