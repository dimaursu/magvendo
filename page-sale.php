<h2><?php _e('Sale product'); ?></h2>

<?php if (isset($_POST['save'])) : ?>
    <?php $error = save_sale(); ?>
<?php endif; ?>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo $error; ?></p>
<?php elseif(isset($error)) : ?>
    <p class="success"><?php _e('The product has been added to sold list.'); ?></p>
<?php endif; ?> 

<form class="input-form" enctype="multipart/form-data" action="index.php?p=sale" method="post">
    <table>
    <tr>
        <td class="first">
          <?php $categories = magv_get_products(); ?>
            <?php _e('Product name'); ?><sup>*</sup>:
        </td>
        <td>
          <select name="product">
             <?php foreach ($categories as $category) : ?>
                 <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
             <?php endforeach; ?>
          </select>
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
            <?php _e('Quantity'); ?>:
        </td>
        <td>
            <input type="number" name="quantity" 
            value="<?php if(!empty($error) && !empty($_POST['quantity']) ) : ?><?php echo $_POST['quantity']; ?><?php endif; ?>" />
        </td>
    </tr>
    <tr>
        <td class="first">
            <?php _e('Discount'); ?>:
        </td>
        <td>
            <input type="text" name="discount" 
            value="<?php if(!empty($error) && !empty($_POST['discount']) ) : ?><?php echo $_POST['discount']; ?><?php endif; ?>" />
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
