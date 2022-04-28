<?php

class model
{

    public $conection;

    ///////////////////////////////////////
    //          conection
    ///////////////////////////////////////

    public function conect()
    {

        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'mini_glosary';

        if ($this->conection === NULL) {
            $this->conection = mysqli_connect($host, $user, $pass);
        }
        mysqli_select_db($this->conection, $db);
        mysqli_query($this->conection, "SET time_zone = '" . date('P') . "'");
        mysqli_query($this->conection, "SET NAMES utf8");
        return $this->conection;
    }

    ///////////////////////////////////////
    //          GENERAL
    ///////////////////////////////////////

    public function check_user($username)
    {
        $this->conect();
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($this->conection, $sql);
        return mysqli_num_rows($result);
    }

    public function insert_user($fullname, $username, $password)
    {
        $this->conect();
        $fullname = filter_var($fullname, FILTER_SANITIZE_STRING);
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $sql = "INSERT INTO users (full_name, username, password) VALUES ('$fullname', '$username', '$password')";
        $result = mysqli_query($this->conection, $sql);
        return $result;
    }

    public function check_login($username, $password)
    {
        $this->conect();
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($this->conection, $sql);
        return $result;
    }

    public function select_idioms()
    {
        $this->conect();
        $sql = "SELECT * FROM idioms";
        $result = mysqli_query($this->conection, $sql);
        return $result;
    }

    public function insert_glossary()
    {
        $this->conect();
        $idiom = filter_var($_POST['glossary_idiom'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['glossary_name'], FILTER_SANITIZE_STRING);
        $items_amount = filter_var($_POST['items_amount'], FILTER_SANITIZE_STRING);

        $sql = "INSERT INTO `glossarys`( `id_user`, `id_idiom`, `title`, `parent_glossary`) 
                VALUES ('$_SESSION[id_user]', '$idiom', '$name',  null )";

        $glossary_result = mysqli_query($this->conection, $sql);
        $glossary_id = mysqli_insert_id($this->conection);

        for ($i = 1; $i <= $items_amount; $i++) {
            if (isset($_POST['description_' . $i])) {
                $item_name = filter_var($_POST['item_' . $i], FILTER_SANITIZE_STRING);
                $item_description = filter_var($_POST['description_' . $i], FILTER_SANITIZE_STRING);
                $sql = "INSERT INTO `glossary_items`( `id_glossary`, `item_name`, `description`) 
                        VALUES ('$glossary_id', '$item_name', '$item_description')";
                $item_result = mysqli_query($this->conection, $sql);
            }
            // echo $item_result . ' - ' . $i . ' - ' . $items_amount . ' - ' . $item_name . ' - ' . $item_description .'<br>';
        }

        return $glossary_result;
    }

    public function select_glossarys($mine = null)
    {
        $this->conect();

        $condition = '';

        if ($mine != null) {
            $condition = " WHERE glossarys.id_user = '" . $_SESSION['id_user'] . "'";
        }

        $result_list = [];

        $sql = "SELECT glossarys.id_glosary, glossarys.title, glossarys.creation_date, idioms.id_idiom, users.username
        FROM glossarys
        LEFT JOIN idioms on glossarys.id_idiom = idioms.id_idiom
        LEFT JOIN users on glossarys.id_user = users.id_user
        $condition
        order by glossarys.id_glosary desc";
        $result = mysqli_query($this->conection, $sql);



        return $result;
    }

    public function select_glossary_items($mine = null, $id_glossary)
    {
        $this->conect();

        $condition = '';

        if ($mine != null) {
            $condition = " and glossarys.id_user = '" . $_SESSION['id_user'] . "'";
        }

        $sql = "SELECT glossary_items.id_item, glossary_items.item_name, glossary_items.description, glossarys.id_glosary
        FROM `glossary_items`
        LEFT JOIN glossarys on glossary_items.id_glossary = glossarys.id_glosary  
        WHERE glossarys.id_glosary = '$id_glossary' $condition
        order by glossary_items.id_item asc";
        $result = mysqli_query($this->conection, $sql);
        return $result;
    }

    public function insert_suggestion($item, $suggestion_text, $id_glossary)
    {

        $this->conect();
        $item = filter_var($item, FILTER_SANITIZE_STRING);
        $suggestion_text = filter_var($suggestion_text, FILTER_SANITIZE_STRING);
        $id_glossary = filter_var($id_glossary, FILTER_SANITIZE_STRING);

        $select = "SELECT * FROM glossary_items WHERE item_name = '$item' AND id_glossary = '$id_glossary'";
        $result = mysqli_query($this->conection, $select);
        $reg = mysqli_fetch_array($result);
        $item = $reg['id_item'];
        $user = $_SESSION['id_user'];

        $sql = "INSERT INTO `suggestions`( `id_glosary`, `id_term`, `id_user`, `suggestion`) 
        VALUES ('$id_glossary', '$item', '$user', '$suggestion_text' )";
        $result = mysqli_query($this->conection, $sql);
        return $result;
    }

    public function select_suggestions($id_glossary)
    {
        $this->conect();
        $sql = "SELECT *
        FROM suggestions
        left join glossary_items on suggestions.id_term = glossary_items.id_item
        where suggestions.id_glosary = '$id_glossary'
        order by suggestions.id_suggestion asc";
        $result = mysqli_query($this->conection, $sql);
        return $result;
    }

    public function search_glossary($search, $mine = null)
    {
        $this->conect();
        $search = filter_var($search, FILTER_SANITIZE_STRING);

        $condition = '';

        if ($mine != null) {
            $condition = " and glossarys.id_user = '" . $_SESSION['id_user'] . "'";
        }


        $sql = "SELECT glossarys.id_glosary, glossarys.title, glossarys.creation_date, idioms.id_idiom, users.username
        FROM glossarys
        LEFT JOIN idioms on glossarys.id_idiom = idioms.id_idiom
        LEFT JOIN users on glossarys.id_user = users.id_user
        WHERE glossarys.title like '%$search%' $condition
        order by glossarys.id_glosary desc";
        $result = mysqli_query($this->conection, $sql);
        return $result; 
    }
    // $_POST['username'], $_POST['pass'], $_POST['fullname']

    public function edit_profile( $username, $password ,$fullname)
    {
        $this->conect();
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $fullname = filter_var($fullname, FILTER_SANITIZE_STRING);

        $user = $_SESSION['id_user'];
        // UPDATE `users` SET `full_name`='[value-2]',`username`='[value-3]',`password`='[value-4]' WHERE id_user = 
        $sql = "UPDATE `users` SET `full_name`='$fullname', `username`='$username', `password`='$password' WHERE `id_user`='$user'";
        $result = mysqli_query($this->conection, $sql);

        $select = "SELECT * FROM users WHERE id_user = '$user'";
        $result = mysqli_query($this->conection, $select);
        return $result;
    }

}
