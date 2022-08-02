<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="upload_content wrapper">
        <form action="" method="post" class="upload_content_form" enctype="multipart/form-data">
            <label class="upload_content_label" for="file_upload">
                <span class="plus_icon"><i class="fas fa-plus-circle"></i></span>
                <span class="upload_text">写真を追加</span>
            </label>
            <input class="input_file" type="file" id="file_upload" name="image">
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
    </section>


    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
