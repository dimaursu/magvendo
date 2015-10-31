<?php if (user_role() != 1) : ?>
    <p><?php _e('You cannot access this page.'); ?></p>
<?php else : ?>
    <h2><?php _e('Add a new user'); ?></h2>

    <?php if (isset($_POST['add'])) : ?>
        <?php $error = save_user(); ?>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif(isset($error)) : ?>
        <p class="success"><?php _e('The user has been added successfully.'); ?></p>
    <?php endif; ?>

    <form class="input-form" enctype="multipart/form-data" action="index.php?p=add-user" method="post">
      <table>
        <tr>
          <td class="first">
            <?php _e('User'); ?>:<sup>*</sup>
          </td>
          <td>
            <input type="text" name="username" autofocus="autofocus" 
                value="<?php if(!empty($error) && !empty($_POST['username']) ) : ?><?php echo $_POST['username']; ?><?php endif; ?>" />
          </td>
        </tr>
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
            <?php _e('Password'); ?>:<sup>*</sup>
          </td>
          <td>
            <input type="password" name="password" value="" />
          </td>
        </tr>
        <tr>
          <td class="first">
            <?php _e('Repeat password'); ?>:<sup>*</sup>
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
                  value="<?php if(!empty($error) && !empty($_POST['phone']) ) : ?><?php echo $_POST['phone']; ?><?php endif; ?>" />
          </td>
      </tr>
      <tr>
          <td class="first">
              <?php _e('Email'); ?>:
          </td>
          <td>
              <input type="email" name="email" 
              value="<?php if(!empty($error) && !empty($_POST['email']) ) : ?><?php echo $_POST['email']; ?><?php endif; ?>" />
          </td>
      </tr>
      <tr>
          <td class="first">
              <?php _e('Address'); ?>:
          </td>
          <td>
              <textarea type="text" name="address"><?php if(!empty($error) && !empty($_POST['address']) ) : ?><?php echo $_POST['address']; ?><?php endif; ?></textarea>
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
        <td class="first">
          <?php _e('Role'); ?>:<sup>*</sup>
        </td>
        <td>
            <input type="radio" name="role" checked="checked' value="0"> <?php _e('User'); ?> </br>
            <input type="radio" name="role" value="1"> <?php _e('Admin'); ?>
        </td>
        </tr>
      <tr>
      <td></td><td><input class="submit" type="submit" name="add" value="<?php _e('Save'); ?>" /></td>
      </tr>
      </table>
    </form>
<?php endif; /* if (user_role() != 1) */ ?> 
