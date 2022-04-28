<?php
include_once '../../model/model.php';
include_once '../../view/view.php';
$model = new model();
$view = new View();
session_start();

$action = $_POST['action'];

switch ($action) {
    case 'check_user':
        $response = $model->check_user($_POST['username']);
        echo $response;
        break;

    case 'insert_user':
        $response = $model->insert_user($_POST['fullname'], $_POST['username'], $_POST['password']);
        echo $response;
        break;

    case 'login':

        $response = $model->check_login($_POST['username'], $_POST['password']);
        $reg = mysqli_fetch_array($response);
        if ($reg['id_user'] > 0) {
            $_SESSION['id_user'] = $reg['id_user'];
            $_SESSION['username'] = $reg['username'];
            $_SESSION['fullname'] = $reg['full_name'];
            $_SESSION['pass'] = $reg['password'];
            echo 1;
        } else {
            echo 0;
        }
        break;

    case 'logout';
        session_destroy();
        break;

    case 'new_glossary';
        $idioms = $model->select_idioms();
        $view->new_glossary($idioms);
        break;

    case 'new_glossary_item':
?>
        <div class="form-group id_item_<?php echo $_POST['item'] ?>">
            <label>Glossary item - Number <?php echo $_POST['item'] ?> <strong onclick="remove_item(<?php echo $_POST['item'] ?>)" style="cursor:pointer" class="text-danger">X</strong></label>
            <input type="text" class="form-control" name="item_<?php echo $_POST['item'] ?>" id="item_<?php echo $_POST['item'] ?>" placeholder="Name">
            <label>Item Description</label>
            <textarea cols="30" rows="5" class="form-control" name="description_<?php echo $_POST['item'] ?>" id="description_<?php echo $_POST['item'] ?>" placeholder="Description"></textarea>
        </div>
    <?php
        break;

    case 'insert_glossary':
        $response = $model->insert_glossary($_POST['name'], $_POST['idiom']);
        echo $response;
        break;

    case 'new_suggestion':
        $item = $_POST['item'];
        $suggestion_text = $_POST['suggestion_text'];
        $id_glossary = $_POST['id_glossary'];
        $response = $model->insert_suggestion($item, $suggestion_text, $id_glossary);
    ?>
        <div class="card mt-3">
            <div class="card-header">
                <?php echo $_SESSION['username'] ?>
            </div>
            <div class="card-body">
                <p class="card-text"> <strong><?php echo $item ?>:</strong> <?php echo $suggestion_text ?></p>
            </div>
        </div>
    <?php
        break;
    case 'search_glossary':
        $glossarys = $model->search_glossary($_POST['search'], $_POST['my']);

        $my = $_POST['my'];
    ?>
        <div class="glossarys_container">
            <?php
            $k = 0;

            while ($reg = mysqli_fetch_array($glossarys)) {
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="h3"><?php echo $reg['username'] ?></span>
                    </div>
                    <div class="card-body" style="background-color:cornsilk">
                        <h4 class="h4"><?php echo $reg['title'] . ' - ' . $reg['creation_date'] ?></h4>
                        <div class="ml-4 mb-3 mt-4">
                            <?php

                            $glosary_items = $model->select_glossary_items($my, $reg['id_glosary']);

                            while ($reg_items = mysqli_fetch_array($glosary_items)) {

                            ?>
                                <div class="row mb-3">
                                    <h5 class="col-lg-2" id="item_<?php echo $reg_items['id_item'] ?>"><?php echo $reg_items['item_name'] ?> : </h5>
                                    <p class="col-lg-10"> <?php echo $reg_items['description'] ?></p>
                                    <input type="hidden" id="item_id_<?php echo $reg_items['id_item'] ?>" value="<?php echo $reg_items['id_item'] ?>">
                                </div>
                            <?php

                            }
                            ?>
                        </div>
                        <div class="w-100 d-flex flex-row justify-content-center mb-3">
                            <button class="btn btn-primary" onclick="change_collapser(1, '<?php echo $k ?>')" type="button" data-toggle="collapse" data-target="#new_sugestion_<?php echo $k ?>" aria-expanded="false" aria-controls="new_sugestion">
                                suggest a new translation of a term
                            </button>
                            <button class="btn btn-primary ml-5" onclick="change_collapser(2, '<?php echo $k ?>')" type="button" data-toggle="collapse" data-target="#collapsse_sugestions_<?php echo $k ?>" aria-expanded="false" aria-controls="collapsse_sugestions">
                                See suggestions
                            </button>
                        </div>
                        <!-- </p> -->
                        <div class="collapse" id="collapsse_sugestions_<?php echo $k ?>">
                            <div class="card card-body see_suggestions_<?php echo $k ?> " style="max-height: 24rem; overflow: scroll;">
                                <?php
                                $suggestions = $model->select_suggestions($reg['id_glosary']);
                                while ($reg_suggestions = mysqli_fetch_array($suggestions)) {
                                ?>
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <?php echo $_SESSION['username'] ?>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"> <strong><?php echo $reg_suggestions['item_name'] ?>:</strong> <?php echo $reg_suggestions['suggestion'] ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="collapse" id="new_sugestion_<?php echo $k ?>">
                            <div class="card card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="w-25 text-center">
                                    <span>item of the suggestion</span>
                                    <select id="suggestion_items_<?php echo $k ?>" class="form-control ">
                                        <option value=""> select an item </option>
                                        <?php
                                        $glosary_items = $model->select_glossary_items($my, $reg['id_glosary']);
                                        while ($reg_items = mysqli_fetch_array($glosary_items)) {
                                        ?>
                                            <option value="<?php echo $reg_items['item_name'] ?>"><?php echo $reg_items['item_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="w-50 text-center">
                                    <span>Suggestion</span>
                                    <textarea id="new_suggestion_text_<?php echo $k ?>" class="w-100" rows="5"></textarea>
                                </div>
                                <input type="button" id="submit_glossary" onclick="new_suggestion('<?php echo $k ?>')" class="btn btn-primary" value="submit Suggestion">
                                <input type="hidden" id="id_glossary_<?php echo $k ?>" value="<?php echo $reg['id_glosary'] ?>">
                            </div>
                        </div>

                    </div>
                </div>
            <?php
                $k++;
            }
            ?>
        </div>
<?php
        break;
    case 'edit_profile':
        $response = $model->edit_profile($_POST['username'], $_POST['pass'], $_POST['fullname']);
        $reg = mysqli_fetch_array($response);
        if ($reg['id_user'] > 0) {
            $_SESSION['id_user'] = $reg['id_user'];
            $_SESSION['username'] = $reg['username'];
            $_SESSION['fullname'] = $reg['full_name'];
            $_SESSION['pass'] = $reg['password'];
            echo 1;
        } else {
            echo 0;
        }
        // echo $response;
        break;
    default:
        echo 'Error';
        break;
}
