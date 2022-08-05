<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

$current_user = '';
$upload_file = '';
$upload_tmp_file = '';
$menu = '';
$description = '';
$shop = '';
$homepage = '';
$errors = [];
$image_name = '';

if (empty($_SESSION['current_user'])) {
    header('Location: index.php');
    exit;
}

$current_user = $_SESSION['current_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // アップロードした画像のファイル名
    $upload_file = $_FILES['image']['name'];
    // サーバー上で一時的に保存されるテンポラリファイル名
    $upload_tmp_file = $_FILES['image']['tmp_name'];
    // メニュー名
    $menu = filter_input(INPUT_POST, 'menu');
    // 画像の説明文
    $description = filter_input(INPUT_POST, 'description');
    // 店名
    $shop = filter_input(INPUT_POST, 'shop');
    // ホームページ
    $homepage = filter_input(INPUT_POST, 'homepage');

    $errors = insert_validate($upload_file, $menu, $description, $shop);


    if (empty($errors)) {
        $image_name = date('YmdHis') . '_' . $upload_file;
        $path = 'images/' . $image_name;

        if (move_uploaded_file($upload_tmp_file, $path)) {
            insert_photo($current_user['id'], $image_name, $menu, $description, $shop, $homepage);
            header('Location: index.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <?php if (!empty($errors)) : ?>
        <ul class="errors">
            <?php foreach ($errors as $error) : ?>
                <li>
                    <?= $error ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <section class="upload_content wrapper">
        <form action="" method="post" class="upload_content_form" enctype="multipart/form-data">
            <label class="upload_content_label" id="preview" for="file_upload">
                <span id="plus_icon" class="plus_icon"><i class="fas fa-plus-circle"></i></span>
                <span id="upload_text" class="upload_text">写真を追加</span>
            </label>

            <input class="input_file" type="file" id="file_upload" name="image" onchange="imgPreView(event)">

            <span class="upload_menu">メニュー名</span>
            <input class="input_text" type="text" name="menu" id="" placeholder="メニュー名を入力してください">
            <span class="upload_menu">詳細</span>
            <textarea class="input_text" name="description" rows="5" placeholder="メニューの詳細を入力してください"></textarea>
            <span class="upload_shop">店名</span>
            <input class="input_text" type="text" name="shop" id="" placeholder="店名を入力してください">
            <span class="upload_homepage">ホームページ</span>
            <input class="input_text" type="text" name="homepage" id="" placeholder="ホームページ名を入力してください">
            <input class="upload_submit" type="submit" value="追加">
        </form>
        <figure class="home__samurai">
            <img src="img/home_samurai.jpg" alt="">
        </figure>
        <figure class="post__samurai">
            <img src="img/post_samurai.png" alt="">
        </figure>
    </section>


    <?php include_once __DIR__ . '/_footer.php' ?>

    <script src="js/upload.js"></script>
</body>

</html>
