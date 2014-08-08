<h2><?php _e('Add a new category'); ?></h2>

<?php if (isset($_POST['add'])) : ?>
    <?php $error = save_category(); ?>
<?php endif; ?>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo $error; ?></p>
<?php elseif(isset($error)) : ?>
    <p class="success"><?php _e('The category has been added successfuly.'); ?></p>
<?php endif; ?> 

<form class="input-form" enctype="multipart/form-data" action="index.php?p=add-category" method="post">
    <table>
    <tr>
        <td class="first">
            <?php _e('Category name'); ?><sup>*</sup>:
        </td>
        <td>
            <input type="text" name="name" autofocus="autofocus" 
                value="<?php if(!empty($error) && !empty($_POST['name']) ) : ?><?php echo $_POST['name']; ?><?php endif; ?>" />
        </td>
    </tr>
    <tr>
        <td class="first">
            <?php _e('Sales percent (repare)'); ?>:
        </td>
        <td>
            <input type="text" name="repared"
                value="<?php if(!empty($error) && !empty($_POST['repared']) ) : ?><?php echo $_POST['repared']; ?><?php endif; ?>" />
        </td>
    </tr>
    </tr>
        <td class="first">
            <?php _e('Description'); ?>:
        </td>
        <td><textarea type="text" name="description"><?php if(!empty($error) && !empty($_POST['description']) ) : ?><?php echo $_POST['description']; ?><?php endif; ?></textarea>
        </td>
    </tr>
    </tr>
    <td></td><td><input class="submit" type="submit" name="add" value="<?php _e('Save'); ?>" /></td>
    </tr>
    </table>
</form>
