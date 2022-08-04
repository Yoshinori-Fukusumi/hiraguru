<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

$photo_id = 0;
$old_image = '';

// セッションにidが保持されていなければ一覧画面にリダイレクト
// パラメータを受け取れなけれらば一覧画面にリダイレクト
if (
    empty($_SESSION['current_user']) ||
    empty($_GET['photo_id'])
) {
    header('Location: index.php');
    exit;
}

$photo_id = filter_input(INPUT_GET, 'photo_id');
$photo = find_photo($photo_id);

$old_image = 'images/' . $photo['image'];

delete_photo($photo_id);

// imagesフォルダに存在する画像の削除
unlink($old_image);

header('Location: index.php');
exit;
