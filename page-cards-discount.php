<?php

if (!defined('MAGSALES')) {
    exit("You can't access this script directly.");
}

unset($error);
if (isset($_POST['save'])) {
    $error = mag_set_cards_discount();
}

$discount = mag_get_cards_discount();

?>

<h2><?php _e('Set cards discount'); ?></h2>
    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif(isset($error)) : ?>
        <p class="success"><?php _e('The cards discount has been save succesfully'); ?></p>
    <?php endif; ?> 
    <form class="input-form" enctype="multipart/form-data" action="index.php?p=cards-discount" method="post">
      <table>
        <tr>
          <td class="first">
            <?php _e('Discount'); ?><sup>*</sup>:
          </td>
          <td>
            <?php if(!empty($error) && !empty($_POST['discount']) ) : ?>
                <?php $name = $_POST['discount']; ?>
            <?php else :?>
                <?php $name = $discount; ?>
            <?php endif; ?>
            <input type="number" name="discount" autofocus="autofocus" 
              value="<?php echo $name; ?>" />
          </td>
      </tr>
        <tr>
          <td></td>
          <td>
            <input class="submit" type="submit" name="save" 
                value="<?php _e('Save'); ?>" />
          </td>
        </tr>
      </table>
    </form>
