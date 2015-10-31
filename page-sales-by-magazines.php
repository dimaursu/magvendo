<h2><?php _e('Sales by magazines'); ?></h2>
<p><a href="index.php?p=add-magazine"><?php _e('Add magazine'); ?></a></p>

<h1><?php _e('Sales'); ?></h1>

<h3><?php _e('Sales in all magazines'); ?></h3>
<ul>
    <li><b><a href="index.php?p=sales-all"><?php _e('All'); ?></a></b></li>
    <?php $workers = get_workes(); ?> 
    <?php foreach($workers as $worker) : ?>
      <?php if(has_worker_role_all(SALE, $worker['id'])) : ?>
          <li><b><a href="index.php?p=sales-all&user_id=<?php echo $worker['id']; ?>"><?php echo $worker['name']; ?></a></b></li>
     <?php endif; ?> 
    <?php endforeach; ?>
</ul>

<h3><?php _e('Sales by magazines'); ?></h3>

<?php $magazines = get_magazines(); ?>

<ul>
  <?php foreach($magazines as $magazine) : ?>    
      <li><h3><?php echo $magazine['name']; ?></h3>
        <ul>
          <li><b><a href="index.php?p=sales-all&magazine_id=<?php echo $magazine['id']; ?>"><?php _e('All'); ?></a></b></li>
           <?php $workers = get_workes(); ?> 
           <?php foreach($workers as $worker) : ?>
             <?php if(has_worker_role_all(SALE, $worker['id']) && worker_has_magazine($worker['id'], $magazine['id'])) : ?>
              <li><b><a href="index.php?p=sales-all&magazine_id=<?php echo $magazine['id']; ?>&user_id=<?php echo $worker['id']; ?>"><?php echo $worker['name']; ?></a></b></li>
             <?php endif; ?> 
          <?php endforeach; ?>
       </ul>
      </li> 
  <?php endforeach; ?>
</ul>