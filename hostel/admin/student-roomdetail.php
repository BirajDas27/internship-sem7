<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) {
	$id = intval($_GET['del']);

	// First, delete related entries in the bills table
	$deleteBills = "DELETE FROM bills WHERE user_id=?";
	$stmt = $mysqli->prepare($deleteBills);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();

	// Then, delete the user from the registration table
	$adn = "DELETE FROM registration WHERE id=?";
	$stmt = $mysqli->prepare($adn);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();

	echo "<script>alert('Student released from room');</script>";
}

?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Manage students</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/manage-students.css">
	<script language="javascript" type="text/javascript">
		function popUpWindow(URLStr, left, top, width, height) {
			var popUpWin = 0;
			if (popUpWin) {
				if (!popUpWin.closed) popUpWin.close();
			}
			popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top);
		}
	</script>
</head>

<body>
	<?php include('includes/header.php'); ?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php'); ?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title" style="margin-top:4%">Room Allotted</h2>
						<div class="panel panel-default">
							<div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">Student Details</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Sno.</th>
											<th>Student Name</th>
											<th>Gender </th>
											<th>Reg no</th>
											<th>Contact No </th>
											<th>room no </th>
											<th>Seater </th>
											<th>Staying From </th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Sno.</th>
											<th>Student Name</th>
											<th>Gender </th>
											<th>Reg no</th>
											<th>Contact no </th>
											<th>Room no </th>
											<th>Seater </th>
											<th>Staying From </th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
										$aid = $_SESSION['id'];
										$ret = "SELECT * FROM registration";
										$stmt = $mysqli->prepare($ret);
										$stmt->execute();
										$res = $stmt->get_result();
										$cnt = 1;
										while ($row = $res->fetch_object()) {
										?>
											<tr>
												<td><?php echo $cnt; ?></td>
												<td><?php echo $row->firstName . ' ' . $row->middleName . ' ' . $row->lastName; ?></td>
												<td><?php echo $row->gender; ?></td>
                                                <td><?php echo $row->regno; ?></td>
												<td><?php echo $row->contactNo; ?></td>
												<td><?php echo $row->roomno; ?></td>
												<td><?php echo $row->seater; ?></td>
												<td><?php echo $row->stayfrom; ?></td>
												<td style="display:flex;justify-content:center">
													<a href="javascript:void(0);" onClick="popUpWindow('full-profile.php?id=<?php echo $row->id; ?>', 100, 100, 600, 400);" title="View Full Details"><i class="fa fa-desktop"></i></a>&nbsp;&nbsp;
													<a href="edit-student.php?id=<?php echo $row->id; ?>" title="Edit Room"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
													<a href="student-roomdetail.php?del=<?php echo $row->id; ?>" title="Release student from room" onclick="return confirm('Do you want to release the student from room?');"><i class="fa fa-close"></i></a>
												</td>
											</tr>
										<?php
											$cnt++;
										} ?>
									</tbody>
								</table>


							</div>
						</div>


					</div>
				</div>



			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>