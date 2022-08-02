<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="signup_content wrapper">
        <h1 class="signup_title">新規ユーザー登録</h1>
        <form class="signup_form" action="" method="post">
            <label class="email_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email">
            <label class="name_label" for="name">ユーザー名</label>
            <input type="text" name="name" id="name" placeholder="UserName">
            <label class="password_label" for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <div class="button_area">
                <input type="submit" value="新規登録" class="signup_button">
                <a href="login.php" class="login_page_button">ログインはこちら</a>
            </div>
        </form>
    </section>

    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
