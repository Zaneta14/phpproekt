<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main class="nofloat">
    <h1>Избриши профил</h1>
    <p>Дали сакате да го избришете профилот за 
       <?php echo htmlspecialchars($last_name) . ', ' . 
                  htmlspecialchars($first_name) .
                  ' (' . htmlspecialchars($email) . ')'; ?>?</p>
    <form action="." method="post">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="admin_id"
               value="<?php echo $admin_id; ?>">
        <input type="submit" value="Delete Account">
    </form>
    <form action="." method="post">
        <input type="submit" value="Cancel">
    </form>
</main>
<?php include '../../view/footer.php'; ?>