<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="login_content wrapper">
        <h1 class="login_title">ログイン</h1>
        <form class="login_form" action="" method="post">
            <label class="email_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email">
            <label class="password_label" for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <div class="button_area">
                <input type="submit" value="ログイン" class="login_button">
                <a href="signup.php" class="signup_page_button">新規ユーザー登録</a>
            </div>
        </form>
    </section>

    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
