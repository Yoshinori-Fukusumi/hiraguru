<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// データベースに接続
$dbh = connect_db();

// セッション開始
session_start();

$current_user = '';

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

$photos = find_photos_all();

//1-2. いいねボタン
if (isset($_REQUEST['like'])) {

    //いいねを押したメッセージの投稿者を調べる
    $contributor = $db->prepare('SELECT user_id FROM photos WHERE id=?');
    $contributor->execute(array($_REQUEST['like']));
    $pressed_message = $contributor->fetch(PDO::FETCH_ASSOC);

    //1-3. いいねを押した人とメッセージ投稿者が同一人物でないか確認
    if ($_SESSION['id'] != $pressed_message['user_id']) {

        //1-4. 過去にいいね済みであるか確認
        $pressed = $db->prepare('SELECT COUNT(*) AS cnt FROM likes WHERE post_id=? AND member_id=?');
        $pressed->execute(array(
            $_REQUEST['like'],
            $_SESSION['id']
        ));
        $my_like_cnt = $pressed->fetch(PDO::FETCH_ASSOC);

        //1-5. いいねのデータを挿入or削除
        if ($my_like_cnt['cnt'] < 1) {
            $press = $db->prepare('INSERT INTO likes SET post_id=?, member_id=?, created=NOW()');
            $press->execute(array(
                $_REQUEST['like'],
                $_SESSION['id']
            ));
            header("Location: index.php?page={$page}");
            exit();
        } else {
            $cancel = $db->prepare('DELETE FROM likes WHERE post_id=? AND member_id=?');
            $cancel->execute(array(
                $_REQUEST['like'],
                $login_user
            ));
            header("Location: index.php?page={$page}");
            exit();
        }
    }
}

?>





<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php foreach ($photos as $photo) : ?>
        <a class="heart" href="index.php?like=<?php echo h($photo['id']); ?>">&#9825;</a>
    <?php endforeach; ?>
</body>

</html>
