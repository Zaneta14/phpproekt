<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main>
    <h1 class="top">Листа на сите корисници</h1>
    <p>За да погледнете или избришете корисник, одберете корисник.</p>
    
    <?php if (count($users) == 0) : ?>
        <p>Нема корисници во овој град</p>
    <?php else : ?>
        <h1>
            <?php echo htmlspecialchars($current_city->getName()); ?>
        </h1>
            <?php foreach ($users as $user) : ?>
            <p>
                <a href="?action=view_user&amp;user_id=<?php
                          echo $user->getID(); ?>">
                    <?php echo htmlspecialchars($user->getFirstName()." ". $user->getLastName()); ?>
                </a>
            </p>
            <?php endforeach; ?>
    <?php endif; ?>
</main>
<?php include '../../view/footer.php'; ?>