<?php

class view
{

    public function login()
    {
?>
        <section id="login_section">

            <script>
                function login() {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'login',
                            username: $('#username').val(),
                            password: $('#password').val()
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response == 1) {
                                window.location.href = "index.php?case=";
                            } else {
                                alert('Username or password is incorrect');
                            }
                        }
                    });
                }

                
            </script>

            <div class="login">

                <form class="rounded d-flex flex-column">
                    <h1 class="h1 text-center mb-4">MINI-GLOSSARY LOGIN</h1>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username" aria-describedby="Userlogin" placeholder="ex: Steve">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <label id="user_log" class="form-text text-center">You are not user? <a href="index.php?case=register">Register</a> </label>
                    <button type="button" onclick="login()" class="btn btn-primary" >Submit</button>
                </form>
            </div>
        </section>

    <?php
    }

    public function register()
    {
    ?>
        <section id="register_section">

            <script>
                function check_user() {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'check_user',
                            username: $('#username').val()
                        },
                        success: function(response) {
                            $('#check_user_label').removeClass('d-none');
                            if (response > 0) {
                                $('#check_user_label').addClass('text-danger');
                                $('#check_user_label').html('Username already exist');
                                $('#check_user_label').removeClass('text-success');
                                $('#user_available').val('0');
                            } else {
                                $('#check_user_label').addClass('text-success');
                                $('#check_user_label').html('Username available');
                                $('#check_user_label').removeClass('text-danger');
                                $('#user_available').val('1');

                            }
                        }
                    });
                }

                function register() {

                    if ($('#user_available').val() == 1 && $('#password_one').val() == $('#password_two').val() && $('#password_one').val() != '' && $('#password_two').val() != '' && $('#username').val() != '' && $('#name').val() != '' && $('#surname').val() != '') {
                        $.ajax({
                            type: "POST",
                            url: "assets/js/ajax.php",
                            data: {
                                action: 'insert_user',
                                fullname: $('#name').val() + ' ' + $('#surname').val(),
                                username: $('#username').val(),
                                password: $('#password_one').val()

                            },
                            success: function(response) {
                                if (response) {
                                    alert('User created');
                                    window.location.href = 'index.php';
                                } else {
                                    alert(response);
                                }
                            }
                        });
                    } else {
                        alert('error in the form, please check de data');
                    }


                }
            </script>

            <div class="register">
                <form class="rounded w-50 d-flex flex-column mb-4">
                    <h1 class="h1 text-center mb-4">MINI-GLOSSARY REGISTER</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" aria-describedby="Userlogin" placeholder="ex: Steve">
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" id="surname" aria-describedby="Userlogin" placeholder="ex: jason">
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username" aria-describedby="Userlogin" onkeyup="check_user()" placeholder="ex: st_jason">
                        <label id="check_user_label" class="form-text d-none"></label>
                        <input type="hidden" id="user_available">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="password_one" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Repeat the Password</label>
                        <input type="password" class="form-control" id="password_two" placeholder="Password">
                    </div>
                    <label id="user_log" class="form-text text-center">You are user? <a href="index.php?">Login</a> </label>
                    <button type="button" onclick="register()" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>

    <?php
    }

    public function navbar()
    {
    ?>
        <nav class="navbar navbar-expand-lg navbar-light">

            <script>
                function logout() {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'logout'
                        },
                        success: function(response) {
                            window.location.reload()
                        }
                    });
                }
            </script>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" style="justify-content: space-between;" id="navbarSupportedContent">
                <a class="navbar-brand" href="index.php">Mini Glossary</a>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link h5" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link h5" href="index.php?case=profile">My Profile</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link h5" href="index.php?case=about">About Us</a>
                    </li>

                </ul>
                <svg id="log_out" onclick="logout()" aria-hidden="true" focusable="false" data-prefix="far" data-icon="person-to-portal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="hover-icon svg-inline--fa fa-person-to-portal fa-xl" style="width: 2rem;height: auto;">
                    <path fill="currentColor" d="M416 0c-38.75 0-83.88 34.88-93.88 188.9c-9.25-30.25-34-53.25-64.88-60.25L179 110.9C153.4 105 126.5 111 105.8 127.1L57.38 164.5c-10.5 8-12.38 23.12-4.25 33.62S76.25 210.5 86.75 202.4L135.1 165c9.5-7.25 21.75-9.875 33.38-7.375L183.4 161L148 248.4c-10.38 25.5-.625 54.75 23 68.87l83.75 50.63c2.375 1.625 3.75 4.125 3.875 6.875c0 .75-.125 1.5-.25 2.25L225 481.4C223.3 487.5 224 494.1 227.1 499.6c3.125 5.625 8.25 9.75 14.38 11.5C243.8 511.6 245.9 512 248.1 512c10.75 0 20.12-7.125 23.12-17.38l33.25-104.5c7-24.37-3.25-50.25-24.88-63.37L227.8 295.5l42-104.7c2.75 3.5 5 7.625 6.375 12l14 46c7.125 23.62 28.63 39 53.38 39.12L391.9 288C405.1 288 416 277.2 416 264.1c0-13.25-10.62-23.5-24-23.62h-23.88C369.1 132.9 390.8 48 416 48c26.5 0 48 93.12 48 208s-21.5 208-48 208c-21.38 0-39.38-60.5-45.63-144h-48.5C328 418.1 350.9 512 416 512c43.75 0 96-44.38 96-256C512 139.2 495.4 0 416 0zM272 96c26.5 0 48-21.5 48-47.1S298.5 0 272 0c-26.5 0-48.01 21.5-48.01 48S245.5 96 272 96zM126.1 316.9L106.2 363.1C105 366.1 102.1 368 99 368H24C10.75 368 0 378.8 0 392S10.75 416 24 416h75c22.38 0 42.62-13.38 51.5-33.1L164 350.5l-9.5-5.875C143 337.6 133.4 328.1 126.1 316.9z" class=""></path>
                </svg>
            </div>
        </nav>
    <?php
    }

    public function footer()
    {
    ?>
        <nav class="navbar navbar-expand-lg navbar-light">

            <script>
                function logout() {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'logout'
                        },
                        success: function(response) {
                            window.location.reload()
                        }
                    });
                }
            </script>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" style="justify-content: space-between;" id="navbarSupportedContent">
                <a class="navbar-brand" href="index.php">Mini Glossary</a>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?case=profile">My Profile</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?case=about">About Us</a>
                    </li>

                </ul>
                <svg id="log_out" onclick="logout()" aria-hidden="true" focusable="false" data-prefix="far" data-icon="person-to-portal" role="img" xmlns="" viewBox="0 0 512 512" class="hover-icon svg-inline--fa fa-person-to-portal fa-xl" style="width: 2rem;height: auto;">

                </svg>
            </div>
        </nav>
    <?php
    }

    public function profile()
    {
    ?>
        <section id="profile">

            <div class="containter">
                <div class="row mt-4 ">

                    <div class="col-lg-12 col-md-12 col-sm12 bg-dark text-white text-center">
                        <h3 class="h3"><?php echo $_SESSION['fullname'] . ' - ' . $_SESSION['username'] ?></h3>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm12 mt-2 ">
                        <div class="d-flex flex-row w-100 justify-content-around">
                            <a href="index.php?case=edit_profile" class="btn btn-secondary w-25 text-uppercase">Edit my profile</a>
                            <a href="index.php?case=profile" class="btn btn-secondary w-25 text-uppercase">My glossarys</a>
                            <a href="index.php?case=new_glossary" class="btn btn-secondary w-25 text-uppercase">New glossary</a>

                        </div>
                    </div>

                </div>


            </div>
            </div>
        </section>
    <?php
    }

    public function new_glossary($idioms)
    {
        $min_glossarys = 3;
        $max_glossarys = 5;
    ?>
        <script>
            function new_item() {
                if ($('#items_amount').val() <= 5) {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'new_glossary_item',
                            item: $('#items_amount').val()
                        },
                        success: function(response) {
                            $('#glossary_items').append(response);
                            $('#items_amount').val(parseInt($('#items_amount').val()) + 1);
                        }
                    });
                } else {
                    alert('You can not add more than 5 items');
                }

            }

            function remove_item(item) {
                $('.id_item_' + item).remove();
                $('#items_amount').val(parseInt($('#items_amount').val()) - 1);
            }
        </script>
        <div class="mb-4 profile-content">
            <form action="index.php?case=insert_glossary" method="post">

                <h2 class="h2 text-center">GLOSSARY</h2>
                <div class="form-group">
                    <label>Glossary Title</label>
                    <input type="text" class="form-control" name="glossary_name" id="glossary_name" placeholder="ex: my first Glossary to 'TITANIC' ">
                </div>
                <div class="form-group">
                    <label>Glossary Idiom</label>
                    <select id="glossary_idiom" name="glossary_idiom" class="form-control">
                        <option value=""> select an idiom </option>
                        <?php
                        while ($reg = mysqli_fetch_array($idioms)) {
                        ?>
                            <option value="<?php echo $reg['id_idiom'] ?>"><?php echo $reg['idiom_name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <h2 class="h2 text-center">GLOSSARY ITEMS</h2>

                <div id="glossary_items">
                    <?php
                    for ($i = 1; $i <= $min_glossarys; $i++) {
                    ?>
                        <div class="form-group">
                            <label>Glossary item - Number <?php echo $i ?> </label>
                            <input type="text" class="form-control" name="item_<?php echo $i ?>" id="item_<?php echo $i ?>" placeholder="Name">
                            <label>Item Description</label>
                            <textarea id="" cols="30" rows="5" class="form-control" name="description_<?php echo $i ?>" id="description_<?php echo $i ?>" placeholder="Description"></textarea>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <input type="hidden" name="items_amount" id="items_amount" value="<?php echo $i ?>">

                <button type="button" onclick="new_item()" class="btn btn-secondary">ADD ITEM</button>
                <button type="submit" class="btn btn-primary">SUBMIT</button>
            </form>
        </div>
    <?php
    }

    public function view_glossarys($glossarys, $my = null)
    {
        $model = new Model();
    ?>
        <section class="glossarys_containter">
            <script>
                function new_suggestion(k) {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'new_suggestion',
                            item: $('#suggestion_items_' + k).val(),
                            suggestion_text: $('#new_suggestion_text_' + k).val(),
                            id_glossary: $('#id_glossary_' + k).val()
                        },
                        success: function(response) {
                            $('.see_suggestions_' + k).append(response);
                            $('#new_sugestion_' + k).removeClass('show');
                            $('#collapsse_sugestions_' + k).addClass('show');
                        }
                    });
                }

                function change_collapser(option, item) {
                    switch (option) {
                        case 1:
                            $('#collapsse_sugestions_' + item).removeClass('show');
                            break;
                        case 2:
                            $('#new_sugestion_' + item).removeClass('show');
                            break;
                    }
                }

                function search_glozary() {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'search_glossary',
                            search: $('#search_glossary').val(),
                            my: '<?php echo $my ?>'
                        },
                        success: function(response) {
                            $('.glossarys_container').html(response);
                            // console.log(response);
                        }
                    });
                }
            </script>
            <div class="w-100 text-center d-flex flex-column justify-content-center align-items-center">
                <span class="ml-4 mb-2">Search a Glossary</span>
                <input type="text" class="form-control w-25 ml-4 mb-4" id="search_glossary" placeholder="Search Glozary for title" onkeyup="search_glozary()">
            </div>
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
        </section>
    <?php

    }

    public function about()
    {
    ?>
        <section id="about_us">
            <h1 class="text-center">About Us</h1>
            <p class="m-4">
            <h3>Mission Statement</h3>
            ProZ.com's mission is to:

            Empower language industry professionals to achieve their business objectives and realize their full potential.

            ProZ.com does this by:

            being committed to member success,
            providing access to state-of-the-art tools,
            educating and inspiring,
            fostering collaboration among positive, like-minded professionals.
            <br>

            <h3>By The Numbers</h3>
            1999

            The year ProZ.com was founded

            1,256,809

            Registered users

            21

            Employees who work for ProZ.com

            3,843,487

            KudoZ translation questions asked

            <h3>Services</h3>

            Serving the world's largest community of translators, ProZ.com delivers a comprehensive network of essential services, resources and experiences that enhance the lives of its members.

            ProZ.com enables language professionals to:

            Outsource and accept translation and interpreting assignments
            Collaborate on terms in the KudoZ™ network
            Evaluate clients with the member-built Blue Board™
            Meet face-to-face at local conferences and ProZ.com Powwows™
            Train and be trained in industry-specific skills
            Do much more
            ProZ.com also owns and operates TM-Town, a platform with a unique new technology to match clients to professional translators with experience translating the specific subject matter the client needs translated.
            </p>
        </section>

    <?php
    }

    public function edit_profile()
    {

    ?>

        <script>
            function check_user() {
                $.ajax({
                    type: "POST",
                    url: "assets/js/ajax.php",
                    data: {
                        action: 'check_user',
                        username: $('#username').val()
                    },
                    success: function(response) {
                        $('#check_user_label').removeClass('d-none');
                        if (response > 0) {
                            $('#check_user_label').addClass('text-danger');
                            $('#check_user_label').html('Username already exist');
                            $('#check_user_label').removeClass('text-success');
                            $('#user_available').val('0');
                        } else {
                            $('#check_user_label').addClass('text-success');
                            $('#check_user_label').html('Username available');
                            $('#check_user_label').removeClass('text-danger');
                            $('#user_available').val('1');

                        }
                    }
                });
            }


            function edit_profile() {
                if ($('#user_available').val() == 1 && $('#password').val() != '' && $('#username').val() != '' && $('#fullname').val() != '') {
                    $.ajax({
                        type: "POST",
                        url: "assets/js/ajax.php",
                        data: {
                            action: 'edit_profile',
                            fullname: $("#fullname").val(),
                            username: $("#username").val(),
                            pass: $("#password").val()
                        },
                        success: function(condition) {
                            // console.log(condition)
                            if (condition) {
                                alert('success');
                                window.location.reload();
                            } else {
                                alert('error');
                            }


                        }
                    });
                } else {
                    alert('error in the form, please check de data');
                }
            }
        </script>

        <div class="mb-4 profile-content">

            <h2 class="h2 text-center">GLOSSARY</h2>
            <div class="form-group">
                <label>My Fullname</label>
                <input type="text" class="form-control" id="fullname" value="<?php echo $_SESSION['fullname'] ?>">
            </div>
            <div class="form-group">
                <label>My Username</label>
                <input type="text" class="form-control" id="username" onkeyup="check_user()" value="<?php echo $_SESSION['username'] ?>">
                <label id="check_user_label" class="form-text d-none"></label>
                <input type="hidden" id="user_available">
            </div>
            <div class="form-group">
                <label>My Password</label>
                <input type="password" class="form-control" id="password" value="<?php echo $_SESSION['pass'] ?>">
            </div>

            <button type="button" class="btn btn-primary" onclick="edit_profile()">EDIT</button>

        </div>
<?php

    }
}
