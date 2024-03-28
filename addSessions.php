<?php
$page = 'sessions';
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';

if (isset($_POST['save'])) {
    $term = mysqli_real_escape_string($conn, $_POST['term']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    if ($_POST['action'] == "add") {
        $sql = $conn->query("INSERT INTO sessions (term, start_date, end_date) VALUES ('$term', '$start_date', '$end_date')");
        echo '<script type="text/javascript">window.location="addSessions.php?act=1";</script>';
    } elseif ($_POST['action'] == "update") {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = $conn->query("UPDATE sessions SET term = '$term', start_date = '$start_date', end_date = '$end_date' WHERE id = '$id'");
        echo '<script type="text/javascript">window.location="addSessions.php?act=2";</script>';
    }
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $conn->query("DELETE FROM sessions WHERE id='" . $_GET['id'] . "'");
    header("location: addSessions.php?act=3");
}

$action = "add";
if (isset($_GET['action']) && $_GET['action'] == "edit") {
    $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

    $sqlEdit = $conn->query("SELECT * FROM sessions WHERE id='" . $id . "'");
    if ($sqlEdit->num_rows) {
        $rowsEdit = $sqlEdit->fetch_assoc();
        extract($rowsEdit);
        $action = "update";
    } else {
        $_GET['action'] = "";
    }
}

if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "1") {
    $errormsg = "<div class='alert alert-success'> Session has been added successfully</div>";
} elseif (isset($_REQUEST['act']) && @$_REQUEST['act'] == "2") {
    $errormsg = "<div class='alert alert-success'> Session has been updated successfully</div>";
} elseif (isset($_REQUEST['act']) && @$_REQUEST['act'] == "3") {
    $errormsg = "<div class='alert alert-success'> Session has been deleted successfully</div>";
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Fees Management System - Add Sessions</title>

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
                    <h1 class="page-head-line">Add Sessions
                        <?php
                        echo (isset($_GET['action']) && @$_GET['action'] == "add" || @$_GET['action'] == "edit") ?
                            ' <a href="addSessions.php" class="btn btn-success btn-sm pull-right" style="border-radius:0%">Go Back </a>' :
                            '<a href="addSessions.php?action=add" class="btn btn-danger btn-sm pull-right" style="border-radius:0%"><i class="glyphicon glyphicon-plus"></i> Add New Session </a>';
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
                                <?php echo ($action == "add") ? "Add Session" : "Edit Session"; ?>
                            </div>
                            <form action="AddSessions.php" method="post" id="sessionForm" class="form-horizontal">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="term">Term</label>
                                        <div class="col-sm-10">
                                            <select name="term" class="custom-select form-control" required>
                                                <option value="">-- Select Session --</option>
                                                <option value="term1" <?php if ($action == 'update' && $term == 'term1') echo 'selected'; ?>>Term 1</option>
                                                <option value="term2" <?php if ($action == 'update' && $term == 'term2') echo 'selected'; ?>>Term 2</option>
                                                <option value="term3" <?php if ($action == 'update' && $term == 'term3') echo 'selected'; ?>>Term 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="start_date">Start Date</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="start_date" class="form-control" value="<?php echo $action == 'update' ? $start_date : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="end_date">End Date</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="end_date" class="form-control" value="<?php echo $action == 'update' ? $end_date : ''; ?>" required>
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
                        if ($("#sessionForm").length > 0) {
                            $("#sessionForm").validate({
                                rules: {
                                    term: "required",
                                    start_date: "required",
                                    end_date: "required"
                                },
                                messages: {
                                    term: "Please select a term",
                                    start_date: "Please select a start date",
                                    end_date: "Please select an end date"
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
                        Manage Sessions
                    </div>
                    <div class="panel-body">
                        <div class="table-sorting table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="sessionTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Term</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM sessions";
                                    $result = $conn->query($sql);
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>
                                            <td>' . $i . '</td>
                                            <td>' . $row['term'] . '</td>
                                            <td>' . $row['start_date'] . '</td>
                                            <td>' . $row['end_date'] . '</td>
                                            <td>
                                                <a href="addSessions.php?action=edit&id=' . $row['id'] . '" class="btn btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-edit"></span></a>
                                                <a onclick="return confirm(\'Are you sure you want to delete this record\');" href="addSessions.php?action=delete&id=' . $row['id'] . '" class="btn btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-remove"></span></a>
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
                        $('#sessionTable').dataTable({
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
