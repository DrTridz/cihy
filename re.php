<?php
ob_start();
# Created by Mohammed Saad ALrmali.              #
# Twitter: z6_q |Date: ١٩/٠٣/٢١ |Time: ١١:٥٢ م    #                   
# Github : github.com/DrTridz - Web : m-saad.net #
include 'admin-cp/template/header.php';
require __DIR__ . '/classes/Upload.php';
include 'appc/conn.php';
date_default_timezone_set('Asia/Riyadh');
$errors = [];
$username = '';
$role = '';
$fullname = '';
$email = '';
$department = '';
$position = '';
$id_work = '';
$id_gov = '';
$phone = '';
$telephone = '';
$extphone = '';



    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $fullname = mysqli_real_escape_string($mysqli, $_POST['fullname']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);
        $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);
        $department = mysqli_real_escape_string($mysqli, $_POST['department']);
        $position = mysqli_real_escape_string($mysqli, $_POST['position']);
        $id_work = mysqli_real_escape_string($mysqli, $_POST['id_work']);
        $id_gov = mysqli_real_escape_string($mysqli, $_POST['id_gov']);
        $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
        $telephone = mysqli_real_escape_string($mysqli, $_POST['telephone']);
        $extphone = mysqli_real_escape_string($mysqli, $_POST['extphone']);

        if(empty($username)){array_push($errors, "Name is required");}
        if(empty($fullname)){array_push($errors, "Full name is required");}
        if(empty($email)){array_push($errors, "Email is required");}
        if(empty($password)){array_push($errors, "Password is required");}
        if (empty($password_confirmation)){array_push($errors, "Password confirmation is required");}
        if ($password != $password_confirmation){
            array_push($errors, "Password don't match");
        }
        if(empty($department)){array_push($errors, "Department is required");}
        if(empty($position)){array_push($errors, "Position is required");}
        if(empty($id_work)){array_push($errors, "Job id number is required");}
        if(empty($id_gov)){array_push($errors, "National ID number, Iqama,or passport is required");}
        if(empty($phone)){array_push($errors, "Phone is required");}
        if(empty($_FILES['image']['name'])){array_push($errors, "Image is required");}

        if(!count($errors)){
            $date = date('Ym');
            $upload = new Upload('uploads2/users2');
            $upload->file = $_FILES['image'];
            $errors = $upload->upload();
        }
        if (!count($errors)){
            $userExists = $mysqli->query("select id, username from users where username='$username' limit 1");
            if ($userExists->num_rows){
                array_push($errors, "user already registered");
            }
        }


        if (!count($errors)){
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = "insert into users (`username`, `fullname`, `email`, `password`,`department`,`position`,
                                     `id_work`,`id_gov`,`phone`,`telephone`,`extphone`,`image`)
                              values ('$username', '$fullname', '$email','$password','$department',
                                        '$position','$id_work','$id_gov','$phone','$telephone','$extphone','$upload->filePath')";
            $mysqli->query($query);


//            header('location: index.php');
//            die();

        }
    }
ob_end_flush();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php include 'errors.php'?>
                    <h4 class="card-title" id="horz-layout-basic">User form register</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">

                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                        </ul>
                    </div>
                </div>
                <div class="card-content collpase show">
                    <div class="card-body">
                        <div class="card-text">
                            <p>Register a new user in the system</p>
                        </div>
                        <form class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <h4 class="form-section"><i class="ft-user"></i> User Info</h4>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput1">username</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput1" class="form-control"
                                               placeholder="Mohammed" value="<?php echo $username ?>" name="username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput2">Full Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput2" class="form-control"
                                               placeholder="Mohammed ALrmali" value="<?php echo $fullname ?>"
                                               name="fullname">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput3">E-mail</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput3" class="form-control" placeholder="E-mail"
                                               value="<?php echo $email ?>" name="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput4">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" id="projectinput4" class="form-control"
                                               placeholder="**********" name="password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput4">Confirm password:</label>
                                    <div class="col-md-9">
                                        <input type="password" id="projectinput4" class="form-control"
                                               placeholder="**********" name="password_confirmation">
                                    </div>
                                </div>

                                <h4 class="form-section"><i class="ft-clipboard"></i> About user</h4>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">Department</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control"
                                               placeholder="Security" value="<?php echo $department ?>"
                                               name="department">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">Position</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control"
                                               placeholder="group leader" value="<?php echo $position ?>"
                                               name="position">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">Job id number</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control" placeholder="22135"
                                               value="<?php echo $id_work ?>" name="id_work">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">National ID number, Iqama,
                                        or passport</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control"
                                               placeholder="1001564648" value="<?php echo $id_gov ?>"
                                               name="id_gov">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">Phone</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control "
                                               placeholder="1001564648" value="<?php echo $phone ?>" name="phone">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">Telephone</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control "
                                               placeholder="013559855" value="<?php echo $telephone ?>"
                                               name="telephone">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput5">Ext</label>
                                    <div class="col-md-9">
                                        <input type="text" id="projectinput5" class="form-control " placeholder="251"
                                               value="<?php echo $extphone ?>" name="extphone">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Image</label>
                                    <div class="col-md-9">
                                        <label id="projectinput8" class="file center-block">
                                            <input type="file" id="file" name="image">
                                            <span class="file-custom"></span>
                                        </label>
                                    </div>
                                </div>
                                <h4 class="form-section"><i class="ft-lock"></i> User Permissions</h4>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="projectinput6">Role</label>
                                    <div class="col-md-9">
                                        <select id="projectinput6" name="role" class="form-control">

                                            <option value="security"<?php if ($role == 'security') echo 'Selected'?>>Security</option>
                                            <option value="employee"<?php if ($role == 'admin') echo 'Selected'?>>Employee</option>
                                            <option value="it"<?php if ($role == 'it') echo 'Selected'?>>IT</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include 'admin-cp/template/footer.php';
