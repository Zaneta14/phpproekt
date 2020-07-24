<aside>
    <ul>
        <?php
            $account_url = $app_name. 'admin/account';
            $logout_url = $app_name . 'admin/account?action=logout';
            if (isset($_SESSION['admin'])) :
            ?>
            <li>
                <a href="<?php echo $logout_url; ?>">Одјави се</a>
            <?php endif; ?>
            </li>
            <li>
                <a href="<?php echo $app_name; ?>">Почетна</a>
            </li>
            <li>
            <?php $admin_url = $app_name.'admin'; ?>
                <a href="<?php echo $admin_url; ?>">Админ Мени</a>
            </li>
            <li>
                <a href="<?php echo $account_url;?>">Профил</a>
            </li>
    </ul>
</aside>