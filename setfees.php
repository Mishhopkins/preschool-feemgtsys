<?php

$page = 'setfees';
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';

if (isset($_POST['save'])) {
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
    $session_id = mysqli_real_escape_string($conn, $_POST['session_id']);
    $admission = mysqli_real_escape_string($conn, $_POST['admission']);
    $academic = mysqli_real_escape_string($conn, $_POST['academic']);
    $lunch = mysqli_real_escape_string($conn, $_POST['lunch']);
    $boarding = mysqli_real_escape_string($conn, $_POST['boarding']);

    if ($_POST['action'] == "add") {
        $sql = $conn->query("INSERT INTO fees (class_id, session_id, admission, academic, lunch_fee, boarding_fee) VALUES ('$class_id', '$session_id', '$admission', '$academic', '$lunch', '$boarding')");
        echo '<script type="text/javascript">window.location="setfees.php?act=1";</script>';
    } elseif ($_POST['action'] == "update") {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = $conn->query("UPDATE fees SET class_id = '$class_id', session_id = '$session_id', admission = '$admission', academic = '$academic', lunch_fee = '$lunch', boarding_fee = '$boarding',  WHERE id = '$id'");
        echo '<script type="text/javascript">window.location="setfees.php?act=2";</script>';
    }
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $conn->query("DELETE FROM fees WHERE id='" . $_GET['id'] . "'");
    header("location: setfees.php?act=3");
}

$action = "add";
if (isset($_GET['action']) && $_GET['action'] == "edit") {
    $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

    $sqlEdit = $conn->query("SELECT * FROM fees WHERE id='" . $id . "'");
    if ($sqlEdit->num_rows) {
        $rowsEdit = $sqlEdit->fetch_assoc();
        extract($rowsEdit);
        $action = "update";
    } else {
        $_GET['action'] = "";
    }
}

if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "1") {
    $errormsg = "<div class='alert alert-success'> Fee has been added successfully</div>";
} elseif (isset($_REQUEST['act']) && @$_REQUEST['act'] == "2") {
    $errormsg = "<div class='alert alert-success'> Fee has been updated successfully</div>";
} elseif (isset($_REQUEST['act']) && @$_REQUEST['act'] == "3") {
    $errormsg = "<div class='alert alert-success'> Fee has been deleted successfully</div>";
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Fees Management System - Set Fees</title>

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
                    <h1 class="page-head-line">Set Fees
                        <?php
                        echo (isset($_GET['action']) && @$_GET['action'] == "add" || @$_GET['action'] == "edit") ?
                            ' <a href="setfees.php" class="btn btn-success btn-sm pull-right" style="border-radius:0%">Go Back </a>' :
                            '<a href="setfees.php?action=add" class="btn btn-danger btn-sm pull-right" style="border-radius:0%"><i class="glyphicon glyphicon-plus"></i> Add New Fee </a>';
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
                                <?php echo ($action == "add") ? "Add Fee" : "Edit Fee"; ?>
                            </div>
                            <form action="setfees.php" method="post" id="feeForm" class="form-horizontal">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="class_id">Class</label>
                                        <div class="col-sm-10">
                                            <select name="class_id" class="custom-select form-control" required>
                                                <option value="">-- Select Class --</option>
                                                <?php
                                                $classSql = "SELECT * FROM classes";
                                                $classResult = $conn->query($classSql);
                                                while ($classRow = $classResult->fetch_assoc()) {
                                                    echo '<option value="' . $classRow['id'] . '" ' . ($action == 'update' && $class_id == $classRow['id'] ? 'selected' : '') . '>' . $classRow['class_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="session_id">Session</label>
                                        <div class="col-sm-10">
                                            <select name="session_id" class="custom-select form-control" required>
                                                <option value="">-- Select Session --</option>
                                                <?php
                                                $sessionSql = "SELECT * FROM sessions";
                                                $sessionResult = $conn->query($sessionSql);
                                                while ($sessionRow = $sessionResult->fetch_assoc()) {
                                                    echo '<option value="' . $sessionRow['id'] . '" ' . ($action == 'update' && $session_id == $sessionRow['id'] ? 'selected' : '') . '>' . $sessionRow['term'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div><br>
                                    <div class="panel-heading">Category</div><br>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="admission">Admission</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="admission" class="form-control" value="<?php echo $action == 'update' ? $admission : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="academic">Academic</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="academic" class="form-control" value="<?php echo $action == 'update' ? $academic : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="lunch">Lunch</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="lunch" class="form-control" value="<?php echo $action == 'update' ? $lunch : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="boarding">Boarding</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="boarding" class="form-control" value="<?php echo $action == 'update' ? $boarding : ''; ?>" required>
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
                        if ($("#feeForm").length > 0) {
                            $("#feeForm").validate({
                                rules: {
                                    class_id: "required",
                                    session_id: "required",
                                    admission: "required",
                                    amount: {
                                        required: true,
                                        number: true
                                    }
                                },
                                messages: {
                                    class_id: "Please select a class",
                                    session_id: "Please select a session",
                                    admission: "Please enter a fee type",
                                    amount: {
                                        required: "Please enter the amount",
                                        number: "Please enter a valid number"
                                    }
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
                        Set Fees
                    </div>
                    <div class="panel-body">
                        <div class="table-sorting table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="feesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>Session</th>
                                        <th>Amount Payable</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $feesSql = "SELECT fees.*, classes.class_name, sessions.term FROM fees
                                                JOIN classes ON fees.class_id = classes.id
                                                JOIN sessions ON fees.session_id = sessions.id";
                                    $feesResult = $conn->query($feesSql);
                                    $i = 1;
                                    while ($feesRow = $feesResult->fetch_assoc()) {
                                         // Calculate the total amount
                                        $totalAmount = $feesRow['admission'] + $feesRow['academic'] + $feesRow['boarding_fee'] + $feesRow['lunch_fee'];
                                        echo '<tr>
                                            <td>' . $i . '</td>
                                            <td>' . $feesRow['class_name'] . '</td>
                                            <td>' . $feesRow['term'] . '</td>
                                            <td>' . $totalAmount . '</td>
                                            <td>
                                            <button class="btn btn-primary btn-xs" style="border-radius:60px;" data-toggle="modal" data-target="#feeStructureModal" data-fee-id="' . $feesRow['id'] . '">View</button>
                                                <a href="setfees.php?action=edit&id=' . $feesRow['id'] . '" class="btn btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-edit"></span></a>
                                                <a onclick="return confirm(\'Are you sure you want to delete this record\');" href="setfees.php?action=delete&id=' . $feesRow['id'] . '" class="btn btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-remove"></span></a>
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
                        $('#feesTable').dataTable({
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


<!-- Modal Structure -->
<div class="modal fade" id="feeStructureModal" tabindex="-1" role="dialog" aria-labelledby="feeStructureModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="feeStructureModalLabel">Fee Structure</h2>
            </div>
            <div class="modal-body" id="feeStructureContent">
                <!-- Content will be dynamically added here -->
            </div>
            <div class="modal-footer">
            
            <button class="btn btn-success" onclick="window.print()">Print</button>
        
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#feeStructureModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var feeId = button.data('fee-id');

        // Make an AJAX request to fetch fee structure details
        $.ajax({
            url: 'get_fee_structure.php', // Replace with the actual endpoint to get fee structure details
            method: 'GET',
            data: { id: feeId },
            success: function (data) {
                // Update the modal content with fee structure details
                $('#feeStructureContent').html(data);
            },
            error: function () {
                alert('Error fetching fee structure details.');
            }
        });
    });
</script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="js/custom1.js"></script>
</body>
</html>
