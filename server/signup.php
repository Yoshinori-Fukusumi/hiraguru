<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// 変数の初期化
$email = '';
$name = '';
$password = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');

    $errors = signup_validate($email, $name, $password);

    if (empty($errors)) {
        insert_user($email, $name, $password);
        header('Location: login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="signup_content wrapper">
        <h1 class="signup_title">新規ユーザー登録</h1>

        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li>
                        <?= h($error) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form class="signup_form" action="" method="post">
            <label class="email_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">
            <label class="name_label" for="name">ユーザー名</label>
            <input type="text" name="name" id="name" placeholder="UserName" value="<?= h($name) ?>">
            <label class="password_label" for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <div class="button_area">
                <input type="submit" value="新規登録" class="signup_button">
                <a href="login.php" class="login_page_button">ログインはこちら</a>
            </div>
        </form>
        <figure class="resister__samurai">
            <img src="img/resister_samurai.png" alt="">
        </figure>

    </section>

    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
