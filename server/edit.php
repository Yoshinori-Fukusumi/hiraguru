<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

//セッション開始
session_start();

$current_user = '';
$photo_id = 0;
$photo = '';
$upload_file = '';
$upload_tmp_file = '';
$menu = '';
$description = '';
$shop = '';
$errors = [];

// セッションにidが保持されていなければ一覧画面にリダイレクト
// パラメータを受け取れなけれらば一覧画面にリダイレクト
if (
    empty($_SESSION['current_user']) ||
    empty($_GET['photo_id'])
) {
    header('Location: index.php');
    exit;
}

$current_user = $_SESSION['current_user'];

$photo_id = filter_input(INPUT_GET, 'photo_id');
$photo = find_photo($photo_id);
$shop = filter_input(INPUT_POST, 'shop');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu = filter_input(INPUT_POST, 'menu');
    $description = filter_input(INPUT_POST, 'description');
    $shop = filter_input(INPUT_POST, 'description');
    $homepage = filter_input(INPUT_POST, 'homepage');

    // アップロードした画像のファイル名
    // 変更がない場合は更新しない
    if ($_FILES['image']['name'] != $photo['image']) {
        $upload_file = $_FILES['image']['name'];
        // サーバー上で一時的に保存されるテンポラリファイル名
        $upload_tmp_file = $_FILES['image']['tmp_name'];
    }

    $errors = update_validate($upload_file, $menu, $description, $shop);

    if (empty($errors)) {
        if (empty($upload_file)) {
            // 後程更新処理
            update_photo($photo_id, $menu, $description, $shop, $homepage);
        } else {
            $image_name = date('YmdHis') . '_' . $_FILES['image']['name'];
            $path = 'images/' . $image_name;
            if (move_uploaded_file($upload_tmp_file, $path)) {
                $old_image = 'images/' . $photo['image'];
                // 後程更新処理
                update_photo($photo_id, $menu, $description, $shop, $homepage, $image_name = '');
                unlink($old_image);
            }
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

    <section class="main_content wrapper">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="content">
                <label for="file_upload" id="preview">
                    <img id="old_img" src="images/<?= h($photo['image']) ?>">
                </label>
                <input class="input_file" type="file" id="file_upload" name="image" onchange="imgPreView(event)">
                <!-- <textarea class="input_text" rows="5" placeholder="画像の詳細を入力してください">画像の説明文</textarea> -->

                <span class="upload_menu">メニュー名</span>
                <input class="input_text" type="text" name="menu" id="menu" placeholder="メニュー名を入力してください" value="<?= h($photo['menu']) ?>">
                <span class="upload_menu">詳細</span>
                <textarea class="input_text" placeholder="メニューの詳細を入力してください" id="description" name="description"><?= h($photo['description']) ?></textarea>
                <span class="upload_shop">店名</span>
                <input class="input_text" type="text" name="shop" id="shop" placeholder="店名を入力してください" value="<?= h($photo['shop']) ?>">
                <span class="upload_homepage">ホームページ</span>
                <input class="input_text" type="text" name="homepage" id="homepage" placeholder="ホームページ名を入力してください" value="<?= h($photo['homepage']) ?>">
                <input class="upload_submit" type="submit" value="追加">

                <div class="button">
                    <input type="submit" value="更 新" class="update_button">
                </div>
            </div>
        </form>
    </section>

    <?php include_once __DIR__ . '/_footer.php' ?>
    <script src="js/upload.js"></script>
</body>

</html>
