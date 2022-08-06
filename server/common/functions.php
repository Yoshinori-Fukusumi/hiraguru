<?php
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    // ENT_QUOTES: シングルクオートとダブルクオートを共に変換する。
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// サインアップバリデーション
function signup_validate($email, $name, $password)
{
    $errors = [];

    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }

    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    if (
        empty($errors) &&
        check_exist_user($email)
    ) {
        $errors[] = MSG_EMAIL_DUPLICATE;
    }

    return $errors;
}

function insert_user($email, $name, $password)
{
    $dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO
        users
        (email, name, password)
    VALUES
        (:email, :name, :password);
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindValue(':password', $pw_hash, PDO::PARAM_STR);

    $stmt->execute();
}

function check_exist_user($email)
{
    $err = false;

    $dbh = connect_db();

    $sql = <<<EOM
    SELECT 
        * 
    FROM 
        users 
    WHERE 
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($user)) {
        $err = true;
    }
    return $err;
}

function login_validate($email, $password)
{
    $errors = [];

    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    return $errors;
}

function find_user_by_email($email)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT
        *
    FROM
        users
    WHERE
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insert_validate($upload_file, $menu, $description, $shop)
{
    $errors = [];

    if (empty($upload_file)) {
        $errors[] = MSG_NO_IMAGE;
    }

    if (empty($menu)) {
        $errors[] = MSG_NO_MENU;
    }

    if (empty($description)) {
        $errors[] = MSG_NO_DESCRIPTION;
    }

    if (empty($shop)) {
        $errors[] = MSG_NO_SHOP;
    } else {
        if (check_file_ext($upload_file)) {
            $errors[] = MSG_NOT_ABLE_EXT;
        }
    }



    return $errors;
}

function check_file_ext($upload_file)
{
    $err = false;

    $file_ext = pathinfo($upload_file, PATHINFO_EXTENSION);
    if (!in_array($file_ext, EXTENTION)) {
        $err = true;
    }

    return $err;
}

function insert_photo($user_id, $image_name, $menu, $description, $shop, $homepage)
{
    $dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO 
        photos
        (user_id ,image, menu, description, shop, homepage) 
    VALUES 
        (:user_id, :image, :menu, :description, :shop, :homepage);
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
    $stmt->bindValue(':menu', $menu, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':shop', $shop, PDO::PARAM_STR);
    $stmt->bindValue(':homepage', $homepage, PDO::PARAM_STR);
    $stmt->execute();
}

function find_photos_all()
{
    $dbh = connect_db();

    $sql = <<<EOM
        SELECT
            * 
        FROM
            photos 
        WHERE 
            created_at BETWEEN NOW() - INTERVAL 3 MONTH AND NOW()
        ORDER BY
            created_at DESC
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function find_photo($id)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT 
        * 
    FROM 
        photos 
    WHERE 
        id = :id;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_validate($upload_file, $menu, $description, $shop)
{
    $errors = [];

    if (empty($menu)) {
        $errors[] = MSG_NO_MENU;
    }

    if (empty($description)) {
        $errors[] = MSG_NO_DESCRIPTION;
    }

    if (empty($shop)) {
        $errors[] = MSG_NO_SHOP;
    }

    if (
        !empty($upload_file) &&
        check_file_ext($upload_file)
    ) {
        $errors[] = MSG_NOT_ABLE_EXT;
    }

    return $errors;
}


function update_photo($id, $menu, $description, $shop, $homepage, $image_name = '')
{
    $dbh = connect_db();

    $sql = <<<EOM
    UPDATE
        photos
    SET
        menu = :menu,
        description = :description,
        shop = :shop,
        homepage = :homepage
    EOM;

    if (!empty($image_name)) {
        $sql .= ', image = :image ';
    }

    $sql .= ' WHERE id = :id';

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':menu', $menu, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':shop', $shop, PDO::PARAM_STR);
    $stmt->bindValue(':homepage', $homepage, PDO::PARAM_STR);

    if (!empty($image_name)) {
        $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
    }

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_photo($id)
{
    $dbh = connect_db();

    $sql = <<<EOM
    DELETE 
        FROM 
    photos 
        WHERE 
    id = :id;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
