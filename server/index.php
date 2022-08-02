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

$photos = find_photos_all()
?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>
    <!-- ヘッダー -->
    <header class="header">
        <div class="header__img__wrapper">
            <img class="img1" src="img/top1.jpg" alt="">
            <img class="img2" src="img/top2.jpg" alt="">
            <img class="img3" src="img/top3.jpg" alt="">
        </div>
        <!-- /.header__img__wrapper -->
        <div class="header__text__body">
            <h1 class="header__title">ひらグル</h1>
            <h2 class="header__title__sub">新着グルメ投稿サイト<br>in 平泉町</h2>
        </div>
        <div class="header__triangle"></div>
        <a class="header__new__btn" href="#arrival">新着グルメを見る</a>
    </header>
    <!-- インナー -->
    <div class="inner">
        <!-- アバウト -->
        <section class="about">
            <div class="about__title__wrapper">
                <h2 class="about__title js-fadeUp">ひらグルとは</h2>
            </div>
            <div class="about__card">
                <div class="about__img__wrapper js-fadeUp">
                    <img src="img/about1.png" alt="">
                </div>
                <div class="about__text__body js-fadeUp">
                    <p class="about__text">
                        ひらグルとは、平泉町の飲食店において、<br>お店側の『新メニューをすぐにお客様に味わってほしい』という想いと、<br>お客側の『新しいメニューをすぐに食べたい』という想いを<br>マッチングさせるサービスです。
                    </p>
                </div>
            </div>
        </section>
    </div>
    <!-- フード -->
    <section class="food">
        <div class="food__title__wrapper">
            <h2 class="food__title js-fadeUp">平泉グルメの魅力</h2>
        </div>
        <ul class="food__list__wrapper">
            <li class="food__list food1 js-fadeUp">
                <figure class="food__img">
                    <img src="img/food1.jpg" alt="">
                </figure>
                <h3 class="food__text">芳醇な肉料理</h3>
                <p class="food__detail">岩手の高原でのびのびと育った肉牛を使った香ばしい肉料理が豊富</p>
            </li>
            <li class="food__list food2 js-fadeUp">
                <figure class="food__img">
                    <img src="img/food2.jpg" alt="">
                </figure>
                <h3 class="food__text">新鮮な魚介料理</h3>
                <p class="food__detail">太平洋・日本海で穫れた魚介類を新鮮なままふんだんに使用</p>
            </li>
            <li class="food__list food3 js-fadeUp">
                <figure class="food__img">
                    <img src="img/food3.jpg" alt="">
                </figure>
                <h3 class="food__text">みずみずしい果物</h3>
                <p class="food__detail">栄養の豊富な雪解け水で育った果物類は至高の甘さを誇る</p>
            </li>
        </ul>
    </section>
    <div class="inner">
        <!-- 新着グルメ(PHP) -->
        <section class="arrival" id="arrival">
            <div class="arrival__title__wrapper">
                <h2 class="arrival__title">新着グルメ</h2>
            </div>
            <ul class="arrival__list__wrapper">
                <?php foreach ($photos as $photo) : ?>
                    <li class="arrival__list">
                        <a class="arrival__img__wrapper" href="show.php">
                            <img src="images/<?= h($photo['image']) ?>">
                        </a>
                        <div class="arrival__text__body">
                            <label class="arrival__label">メニュー名</label>
                            <h3 class="arrival__text__top"><?= h($photo['menu']) ?></h3>
                            <label class="arrival__label">概要</label>
                            <p class="arrival__text"><?= h($photo['description']) ?></p>
                            <label class="arrival__label">店名</label>
                            <p class="arrival__text arrival__shop"><?= h($photo['shop']) ?></p>
                            <label class="arrival__label">ホームページ</label>
                            <p class="arrival__text arrival__url"><?= h($photo['homepage']) ?></p>
                        </div>
                    </li>
                    <div class="arrival__list__line">
                        <img src="img/line.png" alt="">
                    </div>
                <?php endforeach; ?>
            </ul>
            <?php if (!empty($current_user)) : ?>
                <div class="arrival__btn__wrapper">
                    <a class="arrival__btn" href="upload.php">新規投稿</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
    <footer class="footer">
        <p class="footer__text">ひらグル</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
