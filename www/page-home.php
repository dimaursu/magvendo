<?php if(user_role() == ADMIN_ROLE) : ?>
    <?php require_once 'page-salaries.php'; ?>
<?php else: ?>
    <?php if ( has_worker_role(SALE)) : ?>
        <?php require_once 'page-sales.php'; ?>
    <?php elseif ( has_worker_role(REPARE)) : ?> 
        <?php require_once 'page-repared-list.php'; ?>
    <?php elseif ( has_worker_role(FABRICATE)) : ?>
        <?php require_once 'page-fabricated-list.php'; ?>
    <?php endif; ?>
<?php endif; ?>

