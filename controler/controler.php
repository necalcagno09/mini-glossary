<?php

// includes
include_once 'view/view.php';
include_once 'model/model.php';
$view = new View();
$model = new Model();
// session start
session_start();

// this GET is the action to do
$controler = (isset($_GET['case']) ? $_GET['case'] : '');

// check if the user is logged
if (!isset($_SESSION['id_user'])) {

    switch ($controler) {
        case 'register':
            $view->register();
            break;

        default:
            $view->login();
            break;
    }
} else {

    // navbar
    $view->navbar();

    // switch case to do the action
    switch ($controler) {

        case 'profile':
            // we take the glossarys
            $glossarys = $model->select_glossarys('my');
            // we call the profile view
            $view->profile();
            // we call the glosarys view into the profile view
            $view->view_glossarys($glossarys, 'my');
            break;

        case 'new_glossary':
            
            //if the glossary was create successfully
            if (isset($_GET['succes']) and $_GET['succes'] == 1) {
?>
                <script>
                    alert('Glossary created successfully');
                </script>
            <?php
            }
            // we take the idioms
            $idioms = $model->select_idioms();

            // we call the "new_glossary" view
            $view->profile();
            $view->new_glossary($idioms);
            break;

        case 'insert_glossary':
            // insert the glossary and return the id of it
            $response = $model->insert_glossary();
            ?>
            <script>
                window.location.href = "index.php?case=new_glossary&succes=<?php echo $response ?>";
            </script>
<?php
            break;

        case 'about':
            // we call the "about" view
            $view->about();
            break;

        case 'edit_profile':
            // we call the "edit_profile" view
            $view->profile();
            $view->edit_profile();
            break;

        default:
            // we show the "home" view
            $glossarys = $model->select_glossarys();
            $view->view_glossarys($glossarys, null);
            break;
    }

    //footer
    $view->footer();
}
