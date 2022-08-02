<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="main_content wrapper">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="content">
                <label for="file_upload">
                    <img src="https://picsum.photos/200/300">
                </label>
                <input class="input_file" type="file" id="file_upload">
                <!-- <textarea class="input_text" rows="5" placeholder="画像の詳細を入力してください">画像の説明文</textarea> -->
                <span class="upload_menu">メニュー名</span>
                <input class="input_text" type="text" name="menu" id="" placeholder="メニュー名を入力してください">
                <span class="upload_menu">詳細</span>
                <textarea class="input_text" name="description" rows="5" placeholder="メニューの詳細を入力してください"></textarea>
                <span class="upload_shop">店名</span>
                <input class="input_text" type="text" name="shop" id="" placeholder="店名を入力してください">
                <span class="upload_homepage">ホームページ</span>
                <input class="input_text" type="text" name="homepage" id="" placeholder="ホームページ名を入力してください">
                <input class="upload_submit" type="submit" value="追加">

                <div class="button">
                    <input type="submit" value="更 新" class="update_button">
                </div>
            </div>
        </form>
    </section>

    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
