<?php
$page = 'student';
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';
$action = "add";

$id = "";
$sname = '';
$joindate = '';
$contact = '';
$about = '';
$class = ''; // Added this variable
$pname = '';
$location = '';
$pcontact = '';

if (isset($_POST['save'])) {
    $sname = mysqli_real_escape_string($conn, $_POST['sname']);
    $joindate = mysqli_real_escape_string($conn, $_POST['joindate']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $class = mysqli_real_escape_string($conn, $_POST['class']); // Added this line
    $session = mysqli_real_escape_string($conn, $_POST['session']); // Added this line
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $pcontact = mysqli_real_escape_string($conn, $_POST['pcontact']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    

    if ($_POST['action'] == "add") {
       

		$q1 = $conn->query("INSERT INTO student (sname, joindate, contact, about, class, session, pname, pcontact, location) VALUES ('$sname','$joindate','$contact','$about','$class','$session', '$pname', '$pcontact', '$location')");

        $sid = $conn->insert_id;

       echo '<script type="text/javascript">window.location="student.php?act=1";</script>';

    } elseif ($_POST['action'] == "update") {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = $conn->query("UPDATE student SET grade = '$grade', sname = '$sname', contact = '$contact', about = '$about', emailid = '$emailid', class = '$class', session = '$session' WHERE id = '$id'");
        echo '<script type="text/javascript">window.location="student.php?act=2";</script>';
    }
}


if(isset($_GET['action']) && $_GET['action']=="delete"){

$conn->query("UPDATE  student set delete_status = '1'  WHERE id='".$_GET['id']."'");	
header("location: student.php?act=3");

}


$action = "add";
if(isset($_GET['action']) && $_GET['action']=="edit" ){
$id = isset($_GET['id'])?mysqli_real_escape_string($conn,$_GET['id']):'';

$sqlEdit = $conn->query("SELECT * FROM student WHERE id='".$id."'");
if($sqlEdit->num_rows)
{
$rowsEdit = $sqlEdit->fetch_assoc();
extract($rowsEdit);
$action = "update";
}else
{
$_GET['action']="";
}

}


if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Student record has been added!</div>";
}else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Student record has been updated!</div>";
}
else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Student has been deleted!</div>";
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
       <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<link href="css/ui.css" rel="stylesheet" />
	<link href="css/datepicker.css" rel="stylesheet" />	
	
    <script src="js/jquery-1.10.2.js"></script>
	
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   
	
</head>
<?php
include("php/header.php");
?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Manage Students  
						<?php
						echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
						' <a href="student.php" class="btn btn-success btn-sm pull-right" style="border-radius:0%">Go Back </a>':'<a href="student.php?action=add" class="btn btn-danger btn-sm pull-right" style="border-radius:0%"><i class="glyphicon glyphicon-plus"></i> Add New Student</a>';
						?>
						</h1>
                     
<?php

echo $errormsg;
?>
                    </div>
                </div>
				
				
				
        <?php 
		 if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
		 {
		?>
		
			<script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
                <div class="row">
				
                    <div class="col-sm-10 col-sm-offset-1">
               <div class="panel panel-success">
                        <div class="panel-heading">
                           <?php echo ($action=="add")? "Add Student Details": "Edit Student Details"; ?>
                        </div>

						<form action="student.php" method="post" id="signupForm1" class="form-horizontal">
                        <div class="panel-body">
						<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Personal Information:</legend>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Full Name* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="sname" name="sname" value="<?php echo $sname;?>"  />
								</div>
							</div>
							
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Class* </label>
								<div class="col-sm-10">
									<select  class="form-control" id="class" name="class" >
									<option value="" >Select Class</option>
                                    <?php
									$sql = "select * from classes where delete_status='0' order by classes.class_name asc";
									$q = $conn->query($sql);
									
									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($class==$r['id'])?'selected="selected"':'').'>'.$r['class_name'].'</option>';
									}
									?>									
									
									</select>
								</div>
						</div>

						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Term Joined* </label>
								<div class="col-sm-10">
									<select  class="form-control" id="session" name="session" >
									<option value="" >Select Session</option>
                                    <?php
									$sql = "select * from sessions ";
									$q = $conn->query($sql);
									
									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($class==$r['id'])?'selected="selected"':'').'>'.$r['term'].'</option>';
									}
									?>									
									
									</select>
								</div>
						</div>

						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">DOJ* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Date of Joining" id="joindate" name="joindate" value="<?php echo  ($joindate!='')?date("Y-m-d", strtotime($joindate)):'';?>" style="background-color: #fff;" readonly />
								</div>
							</div>
						 </fieldset>
						
						
							<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Parent/Guardian Information:</legend>
						
						 <div class="form-group">
								<label class="col-sm-2 control-label" for="Old"> Parent/Guardian Full Name* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="pname" name="pname" value="<?php echo $pname;?>"  />
								</div>
							</div>

						 <div class="form-group">
								<label class="col-sm-2 control-label" for="Old"> Parent/Guardian Contact* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact;?>" maxlength="10" />
								</div>
							</div>

						 <div class="form-group">
								<label class="col-sm-2 control-label" for="Old"> Location (Area of residence)* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="location" name="location" value="<?php echo $location;?>" />
								</div>
							</div>
							
							
							</fieldset>
							
							 <fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Optional Information:</legend>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Password">About Student </label>
								<div class="col-sm-10">
	                        <textarea class="form-control" id="about" name="about"><?php echo $about;?></textarea >
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">2nd Parent Contact </label>
								<div class="col-sm-10">
									
									<input type="text" class="form-control" id="pcontact" name="pcontact" value="<?php echo $pcontact;?>"  />
								</div>
						    </div>
							</fieldset>
						
						<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="id" value="<?php echo $id;?>">
								<input type="hidden" name="action" value="<?php echo $action;?>">
								
									<button type="submit" name="save" class="btn btn-success" style="border-radius:0%">Save </button>
								 
								   
								   
								</div>
							</div>
                         
                           
                           
                         
                           
                         </div>
							</form>
							
                        </div>
                            </div>
            
			
                </div>

				<script type="text/javascript">
			   
				$(document).ready(function () {
    $("#joindate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "1970:<?php echo date('Y');?>"
    });

    if ($("#signupForm1").length > 0) {
        $("#signupForm1").validate({
            rules: {
                sname: {
                    required: true
                },
                class: {
                    required: true
                },
				session: {
                    required: true
                },
                joindate: {
                    required: true
                },
                pname: {
                    required: true
                },
				location: {
                    required: true
                },
                
                contact: {
                    required: true,
                    digits: true
                }
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
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
            success: function (label, element) {
                if (!$(element).next("span")[0]) {
                    $("<span class='glyphicon glyphicon-ok form-control-feedback'></span>").insertAfter($(element));
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".col-sm-10").addClass("has-error").removeClass("has-success");
                $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".col-sm-10").addClass("has-success").removeClass("has-error");
                $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
            }
        });
    }
});

</script>

			   
		<?php
		}else{
		?>
		
		 <link href="css/datatable/datatable.css" rel="stylesheet" />
		 
		
		 
		 
		<div class="panel panel-default">
    <div class="panel-heading">
        Manage Student and Parent Details
    </div>
    <div class="panel-body">
        <div class="table-sorting table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tSortable22">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Parent Name</th>
                        <th>Parent Contact</th>
						<th>Joined On</th>
						<th>Other Parent Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
           $sql = "SELECT student.*, student.pname AS parent_name, student.pcontact AS parent_contact, classes.class_name
           FROM student
           JOIN classes ON student.class = classes.id
           WHERE student.delete_status='0'";
   $q = $conn->query($sql);
   $i = 1;
   
   while ($r = $q->fetch_assoc()) {
       echo '<tr>
               <td>' . $i . '</td>
               <td>' . $r['sname'] . '</td>
               <td>' . $r['class_name'] . '</td>
               <td>' . $r['pname'] . '</td>
               <td>' . $r['contact'] . '</td>
               <td>' . date("d M y", strtotime($r['joindate'])) . '</td>
               <td>' . $r['pcontact'] . '</td>
               <td>
                   <a href="student.php?action=edit&id=' . $r['id'] . '" class="btn btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-edit"></span></a>
                   <a onclick="return confirm(\'Are you sure you want to deactivate this record\');" href="student.php?action=delete&id=' . $r['id'] . '" class="btn btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-remove"></span></a>
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
    $(document).ready(function () {
        $('#tSortable22').dataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": false,
            "autoWidth": true
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
