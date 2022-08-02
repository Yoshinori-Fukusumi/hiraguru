<header class="page_header wrapper">
    <h1>
        <a class="logo" href="index.php">
            PHOTO LIST
        </a>
    </h1>

    <div class="right_content">
        <div class="login_info">

            <?php if (!empty($current_user)) : ?>
                <p>
                    <?= $current_user['name'] ?>さん
                </p>
                <a class="header_logout_button" href="" class="nav-link">ログアウト</a>
            <?php else : ?>
                <a class="header_login_button" href="login.php" class="nav-link">ログイン</a>
            <?php endif; ?>

            <a class="home_icon" href="index.php">
                <i class="fa-solid fa-house"></i>
            </a>

        </div>
    </div>
</header>
