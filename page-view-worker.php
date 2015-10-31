<?php

if (empty($_GET['id']) || !is_numeric($_GET['id']))
  {
      $worker = array();
  }
else
  {
      $worker = mags_get_worker($_GET['id']);
  }
?>

<?php  if (empty($worker)) : ?>
<p><?php _e('No such worker'); ?></p>
<?php else: ?>
<h2><?php echo $worker['name']; ?></h2>

        <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-user&id=<?php echo $_GET['id']; ?>" method="post">
          <table>
            <tr>
              <td class="first">
                <?php _e('User'); ?>:<sup>*</sup>
              </td>
              <td>
                <input type="text" name="username" autofocus="autofocus" 
                    value="<?php if(!empty($error) && !empty($_POST['username']) ) : ?><?php echo $_POST['username']; ?><?php else: ?><?php echo $worker['username']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Name'); ?>:<sup>*</sup>
              </td>
              <td>
                <input type="text" name="name"  
                    value="<?php if(!empty($error) && !empty($_POST['name']) ) : ?><?php echo $_POST['name']; ?><?php else: ?><?php echo $worker['name']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Password'); ?>:
              </td>
              <td>
                <input type="password" name="password" value="" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Repeat password'); ?>:
              </td>
              <td>
                <input type="password" name="rpassword" value="" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Phone'); ?>:
              </td>
              <td>
                <input type="tel" name="phone" 
                 value="<?php if(!empty($error) && !empty($_POST['phone']) ) : ?><?php echo $_POST['phone']; ?><?php else: ?><?php echo $worker['phone']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Email'); ?>:
              </td>
              <td>
                <input type="email" name="email" 
                 value="<?php if(!empty($error) && !empty($_POST['email']) ) : ?><?php echo $_POST['email']; ?><?php else: ?><?php echo $worker['email']; ?><?php endif; ?>" />
              </td>
            </tr>
            <tr>
              <td class="first">
                <?php _e('Address'); ?>:
              </td>
              <td>
                <textarea type="text" name="address"><?php if(!empty($error) && !empty($_POST['address']) ) : ?><?php echo $_POST['address']; ?><?php else: ?><?php echo $worker['address']; ?><?php endif; ?></textarea>
              </td>
            </tr>
              <td class="first">
                <?php _e('More information'); ?>:
              </td>
              <td><textarea type="text" name="description"><?php if(!empty($error) && !empty($_POST['description']) ) : ?><?php echo $_POST['description']; ?><?php else: ?><?php echo $worker['description']; ?><?php endif; ?></textarea>
              </td>
            </tr>
            <tr>
              <td></td><td><input class="submit" type="submit" name="update" value="<?php _e('Save'); ?>" /></td>
            </tr>
          </table>
        </form>

    <h2><?php _e("Wroker roles"); ?></h2>

        <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-user&id=<?php echo $_GET['id']; ?>" method="post">
          <table>
            <tr>
            <th>Magazine</th>
            <th>Roles</th>
            </tr>
            <tr>
              <td><input class="submit" type="submit" name="update" value="<?php _e('Save'); ?>" /></td>
            </tr>
          </table>
        </form>

<?php endif; ?>
