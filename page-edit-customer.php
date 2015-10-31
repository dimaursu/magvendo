<?php if (user_role() != 1) : ?>
    <p><?php _e('You cannot access this page.'); ?></p>
<?php else : ?>
    <h2><?php _e('Edit customer'); ?></h2>

    <?php if (!isset($_GET['id']) || !is_numeric($_GET['id'])) : ?>
        <p><?php _e('The customer doesn\'t exit.'); ?></p>
    <?php else: ?>
        <?php if (isset($_POST['update'])) : ?>
            <?php $error = mag_save_customer(); ?>
        <?php endif; ?>
        <?php $customer = mag_get_customer($_GET['id']); ?>
        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif(isset($error)) : ?>
            <p class="success"><?php _e('The customer has been updated succesfully.'); ?></p>
        <?php endif; ?>

        <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-customer&id=<?php echo $_GET['id']; ?>" method="post">
          <table>
            <tr>
              <td class="first">
                <?php _e('Name'); ?>:<sup>*</sup>
              </td>
              <td>
                <input type="text" name="name"  
                    value="<?php if(!empty($error) && !empty($_POST['name']) ) : ?><?php echo $_POST['name']; ?><?php else: ?><?php echo $customer['name']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Phone'); ?>:
              </td>
              <td>
                <input type="tel" name="phone" 
                 value="<?php if(!empty($error) && !empty($_POST['phone']) ) : ?><?php echo $_POST['phone']; ?><?php else: ?><?php echo $customer['phone']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Email'); ?>:
              </td>
              <td>
                <input type="email" name="email" 
                 value="<?php if(!empty($error) && !empty($_POST['email']) ) : ?><?php echo $_POST['email']; ?><?php else: ?><?php echo $customer['email']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Birthday'); ?>:
              </td>
              <td>
                <?php $birthday = date("d-m-Y", strtotime($customer['birthday']));?>
                <input type="text" name="birthday" placeholder="<?php _e('dd-mm-yyyy, for example, 09-05-1984'); ?>"
                 value="<?php if(!empty($error) && !empty($_POST['birthday']) ) : ?><?php echo $_POST['birthday']; ?><?php else: ?><?php echo $birthday; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td></td><td><input class="submit" type="submit" name="update" value="<?php _e('Save'); ?>" /></td>
            </tr>
          </table>
        </form>
    <?php endif; /* if (!isset($_GET['id']) || !is_numeric($_GET['id'])) */ ?>
<?php endif; /* if (user_role() != 1) */ ?> 
