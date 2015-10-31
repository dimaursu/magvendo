<?php

if (empty($_GET['id']) || !is_numeric($_GET['id']))
  {
      $worker = array();
  }
else
  {
      if (isset($_POST['update']))
        {
            $error = save_user();
        }
      else if(isset($_POST['update_roles']))
        {
            $error = mags_update_worker_roles();
        }

      $worker = mags_get_worker($_GET['id']);

     $archive = 0;

     if (!empty($error) && !empty($_POST['archive']))
       {
           $archive = 1;
       }
     else if (!empty($error) && empty($_POST['archive']))
       {
           $archive = 0;
       }
     else
      {
          $archive = $worker['status'] ? 1 : 0;
      }
  }
?>

<?php  if (empty($worker)) : ?>
<p><?php _e('No such worker'); ?></p>
<?php else: ?>
<h2><?php echo $worker['name']; ?></h2>

        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif(isset($error)) : ?>
            <p class="success"><?php _e('The worker has been updated succesfully.'); ?></p>
        <?php endif; ?>

        <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-worker&id=<?php echo $_GET['id']; ?>" method="post">
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
            </tr>
              <td class="first">
                <?php _e('Archive'); ?>:
              </td>
              <td><input type="checkbox" name="archive" <?php if($archive) : ?>checked="checked"<?php endif; ?>>
              </td>
            </tr>
            <tr>
              <td></td><td><input class="submit" type="submit" name="update" value="<?php _e('Save'); ?>" /></td>
            </tr>
          </table>
        </form>

    <h2><?php _e("Wroker roles"); ?></h2>

            <?php $magazines = get_magazines(); ?>
            <?php foreach($magazines as $magazine) : ?>
        <form class="input-form" enctype="multipart/form-data" action="index.php?p=edit-worker&id=<?php echo $_GET['id']; ?>" method="post">

                  <h3><?php echo $magazine['name']; ?><input type="hidden" name="magazine" value="<?php echo $magazine['id']; ?>"></h3>
                  <ul>
    <li><input type="checkbox" name="sell" <?php if(has_worker_role(SALE, $worker['id'], $magazine['id'])) : ?>checked="checked"<?php endif; ?> value="<?php echo SALE; ?>"> <?php echo $work_roles[SALE]; ?></li>
                     <li><input type="checkbox" name="repare" <?php if(has_worker_role(REPARE, $worker['id'], $magazine['id'])) : ?>checked="checked"<?php endif; ?> value="<?php echo REPARE; ?>"> <?php echo $work_roles[REPARE]; ?></li>
                     <li><input type="checkbox" name="fabricate" <?php if(has_worker_role(FABRICATE, $worker['id'], $magazine['id'])) : ?>checked="checked"<?php endif; ?> value="<?php echo FABRICATE; ?>"> <?php echo $work_roles[FABRICATE]; ?></li>
                  </ul>
                  <input class="submit" type="submit" name="update_roles" value="<?php _e('Save'); ?>" />
            </form>
            <?php endforeach; ?>
<?php endif; ?>
