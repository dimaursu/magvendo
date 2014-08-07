<h2><?php _e('Add repared product'); ?></h2>

<?php if (isset($_POST['save'])) : ?>
    <?php $error = save_repared(); ?>
<?php endif; ?>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo $error; ?></p>
<?php elseif(isset($error)) : ?>
    <p class="success"><?php _e('The product has been saved to repared list.'); ?></p>
<?php endif; ?> 

<form class="input-form" enctype="multipart/form-data" action="index.php?p=add-repared" method="post">
    <table>
    <tr>
        <td class="first">
            <?php _e('Product name'); ?><sup>*</sup>:
        </td>
        <td>
            <input type="text" name="name" autofocus="autofocus" 
                value="<?php if(!empty($error) && !empty($_POST['name']) ) : ?><?php echo $_POST['name']; ?><?php endif; ?>">
        </td>
    </tr>
    <tr>
        <td class="first">
            <?php _e('Price'); ?><sup>*</sup>:
        </td>
        <td>
            <input type="text" name="price" 
            value="<?php if(!empty($error) && !empty($_POST['price']) ) : ?><?php echo $_POST['price']; ?><?php endif; ?>" />
        </td>
    </tr>
    <tr>
        <td class="first">
            <?php _e('Salary percent'); ?><sup>*</sup>:
        </td>
        <td>
            <input type="text" name="salary_percent" 
            value="<?php if(!empty($error) && !empty($_POST['salary_percent']) ) : ?><?php echo $_POST['salary_percent']; ?><?php endif; ?>" />
        </td>
    </tr>
    <tr>
        <td class="first">
            <?php _e('Date'); ?>:
        </td>
        <td>
            <input class="date" type="text" name="date" 
            value="<?php if(!empty($error) && !empty($_POST['date']) ) : ?><?php echo $_POST['date']; ?><?php endif; ?>" />
        </td>
    </tr>
    <td></td><td><input class="submit" type="submit" name="save" value="<?php _e('Save'); ?>"></td>
    </tr>
    </table>
</form>
