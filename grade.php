<?php
$page = 'grade';
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';
$action = "add";

$class_name = '';
$id = '';

if (isset($_POST['save'])) {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    // Concatenate type and level to form class_name
    $class_name = $type . '.' . $level;

    if ($_POST['action'] == "add") {
        $sql = $conn->query("INSERT INTO classes (class_name, type, level) VALUES ('$class_name', '$type', '$level')");
        echo '<script type="text/javascript">window.location="grade.php?act=1";</script>';
    } else if ($_POST['action'] == "update") {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = $conn->query("UPDATE classes SET class_name = '$class_name', type = '$type', level = '$level' WHERE id = '$id'");
        echo '<script type="text/javascript">window.location="grade.php?act=2";</script>';
    }
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $conn->query("UPDATE classes SET delete_status = '1' WHERE id='" . $_GET['id'] . "'");
    header("location: grade.php?act=3");
}

$action = "add";
if (isset($_GET['action']) && $_GET['action'] == "edit") {
    $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

    $sqlEdit = $conn->query("SELECT * FROM classes WHERE id='" . $id . "'");
    if ($sqlEdit->num_rows) {
        $rowsEdit = $sqlEdit->fetch_assoc();
        extract($rowsEdit);
        $action = "update";
    } else {
        $_GET['action'] = "";
    }
}

if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "1") {
    $errormsg = "<div class='alert alert-success'> Class has been added successfully</div>";
} else if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "2") {
    $errormsg = "<div class='alert alert-success'> Class has been updated successfully</div>";
} else if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "3") {
    $errormsg = "<div class='alert alert-success'> Class has been deleted successfully</div>";
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Fees Management System</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!-- CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />

    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="js/jquery-1.10.2.js"></script>
</head>

<?php
include("php/header.php");
?>

<body>
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Classes
                        <?php
                        echo (isset($_GET['action']) && @$_GET['action'] == "add" || @$_GET['action'] == "edit") ?
                            ' <a href="grade.php" class="btn btn-success btn-sm pull-right" style="border-radius:0%">Go Back </a>' :
                            '<a href="grade.php?action=add" class="btn btn-danger btn-sm pull-right" style="border-radius:0%"><i class="glyphicon glyphicon-plus"></i> Add New Class </a>';
                        ?>
                    </h1>
                    <?php
                    echo $errormsg;
                    ?>
                </div>
            </div>

            <?php
            if (isset($_GET['action']) && @$_GET['action'] == "add" || @$_GET['action'] == "edit") {
            ?>
                <script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <?php echo ($action == "add") ? "Add Level" : "Edit Grade"; ?>
                            </div>
                            <form action="grade.php" method="post" id="signupForm1" class="form-horizontal">
                                <div class="panel-body">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="Old">Type</label>
										<div class="col-sm-10">
											<select name="type" class="custom-select form-control" required>
												<option value=""> --Select Type-- </option>
												<option value="Day Care" <?php echo ($action == 'update' && $type == 'Day Care') ? 'selected' : ''; ?>>Day Care</option>
												<option value="PlayGroup" <?php echo ($action == 'update' && $type == 'PlayGroup') ? 'selected' : ''; ?>>PlayGroup / BabyClass</option>
												<option value="Pre-Primary" <?php echo ($action == 'update' && $type == 'Pre-Primary') ? 'selected' : ''; ?>>Pre-Primary(PP)</option>
												<option value="Grade" <?php echo ($action == 'update' && $type == 'Grade') ? 'selected' : ''; ?>>Grade</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" for="Confirm">Level</label>
										<div class="col-sm-10">
											<select name="level" class="custom-select form-control" required>
												<option value="">-- Select Level --</option>
												<?php
												for ($i = 0; $i <= 9; $i++) {
													echo '<option value="' . $i . '" ' . ($action == 'update' && $level == $i ? 'selected' : '') . '>' . $i . '</option>';
												}
												?>
											</select>
										</div>
									</div>

                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                                            <button type="submit" name="save" class="btn btn-success" style="border-radius:0%">Save </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        if ($("#signupForm1").length > 0) {
                            $("#signupForm1").validate({
                                rules: {
                                    type: "required",
                                },
                                messages: {
                                    type: "Please enter class name",
                                },
                                errorElement: "em",
                                errorPlacement: function(error, element) {
                                    error.addClass("help-block");
                                    element.parents(".col-sm-10").addClass("has-feedback");
                                    if (element.prop("type") === "checkbox") {
                                        error.insertAfter(element.parent("label"));
                                    } else {
                                        error.insertAfter(element);
                                    }
                                    if (!element.next("span")[0]) {
                                        $("<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
                                    }
                                },
                                success: function(label, element) {
                                    if (!$(element).next("span")[0]) {
                                        $("<span class='glyphicon glyphicon-ok form-control-feedback'></span>").insertAfter($(element));
                                    }
                                },
                                highlight: function(element, errorClass, validClass) {
                                    $(element).parents(".col-sm-10").addClass("has-error").removeClass("has-success");
                                    $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
                                },
                                unhighlight: function(element, errorClass, validClass) {
                                    $(element).parents(".col-sm-10").addClass("has-success").removeClass("has-error");
                                    $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
                                }
                            });
                        }
                    });
                </script>
            <?php
            } else {
            ?>
                <link href="css/datatable/datatable.css" rel="stylesheet" />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Classes
                    </div>
                    <div class="panel-body">
                        <div class="table-sorting table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Level</th>
                                        <th>Class</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM classes WHERE delete_status='0'";
                                    $q = $conn->query($sql);
                                    $i = 1;
                                    while ($r = $q->fetch_assoc()) {
                                        echo '<tr>
                                            <td>' . $i . '</td>
                                            <td>' . $r['type'] . '</td>
                                            <td>' . $r['level'] . '</td>
                                            <td>' . $r['class_name'] . '</td>
                                            <td>
                                                <a href="grade.php?action=edit&id=' . $r['id'] . '" class="btn btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-edit"></span></a>
                                                <a onclick="return confirm(\'Are you sure you want to delete this record\');" href="grade.php?action=delete&id=' . $r['id'] . '" class="btn btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-remove"></span></a>
                                            </td>
                                        </tr>';
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <script src="js/dataTable/jquery.dataTables.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#tSortable22').dataTable({
                            "bPaginate": true,
                            "bLengthChange": false,
                            "bFilter": true,
                            "bInfo": false,
                            "bAutoWidth": true
                        });
                    });
                </script>
            <?php
            }
            ?>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->

<!-- BOOTSTRAP SCRIPTS -->
<script src="js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="js/custom1.js"></script>
</body>
</html>
