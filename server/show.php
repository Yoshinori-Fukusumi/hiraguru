<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

$current_user = '';

// パラメータが渡されていなけらば一覧画面に戻す
$photo_id = filter_input(INPUT_GET, 'photo_id');
if (empty($photo_id)) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

// idを基にデータを取得
$photo = find_photo($photo_id);

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="main_content wrapper">
        <div class="content">
            <img src="images/<?= h($photo['image']); ?>">
            <span class="show__menu show__content__title">メニュー名</span>
            <p>
                <?= h($photo['menu']); ?>
            </p>
            <span class="show__menu show__content__title">詳細</span>
            <p>
                <?= h($photo['description']); ?>
            </p>
            <span class="show__shop show__content__title">店名</span>
            <p>
                <?= h($photo['shop']); ?>
            </p>
            <span class="show__homepage show__content__title">ホームページ</span>
            <p>
                <?= h($photo['homepage']); ?>
            </p>
            <?php if (!empty($current_user) && $current_user['id'] == $photo['user_id']) : ?>
                <div class="button">
                    <!-- <a href="edit.php?photo_id=<?= h($photo['id']) ?>" class="edit_button">編 集</a> -->
                    <button class="delete_button" onclick="if (!confirm('本当に削除してよろしいですか？')) {return false};location.href='delete.php?photo_id=<?= h($photo['id']) ?>'">削 除</button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
