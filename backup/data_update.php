<?php
/* 
	This file will get the data from webpage and update them in the database	
*/

// 	get the information of which database need to be updated
$para = "";

$_datatable = $_POST['dataTable'];
$_id = $_POST['jobid'];

$_warehouse = $_POST['warehouse'];
$para = $para.FilterNAData("WAREHOUSE", $_warehouse);

$_category  = $_POST['category'];
$para = $para.FilterNAData(",CATEGORY", $_category);

$_statue    = $_POST['statue'];
$para = $para.FilterNAData(",STATUS", $_statue);

$_rental    = $_POST['rental'];
$para = $para.FilterNAData(",RENTALREPAIRQUOTENO", $_rental);

$_todo 	    = $_POST['todo'];
$para = $para.FilterNAData(",TODO", $_todo);

$_schedule  = $_POST['schedule'];
$para = $para.FilterNAData(",SCHEDULED DATE", $_schedule);

$_adminnote = $_POST['adminnote'];
$para = $para.FilterNAData(",ADMINNOTES", $_adminnote);

$_serviceAdmin = $_POST['serviceadmin'];
$para = $para.FilterNAData(",SERVICE ADMIN", $_serviceAdmin);

$_partrep = $_POST['partrep'];
$para = $para.FilterNAData(",PARTS REP", $_partrep);

$_cust_po = $_POST['cust_po'];
$para = $para.FilterNAData(",CUST_PO", $_cust_po);

$_qty_backorder = $_POST['qty_backorder'];
$para = $para.FilterNAData(",QTY_BACKORDER", $_qty_backorder);

$_defectrating = $_POST['defectrating'];
$para = $para.FilterNAData(",DEFECTRATING", $_defectrating);

$_cf1 = $_POST['cf1'];
$para = $para.FilterNAData(",CF1", $_cf1);

$_cf2 = $_POST['cf2'];
$para = $para.FilterNAData(",CF2", $_cf2);

$_cf3 = $_POST['cf3'];
$para = $para.FilterNAData(",CF3", $_cf3);

$_si1 = $_POST['si1'];
$para = $para.FilterNAData(",Sl1", $_si1);

$_si2 = $_POST['si2'];
$para = $para.FilterNAData(",SI2", $_si2);

$_servicenote = $_POST['servicenote'];
$para = $para.FilterNAData(",SERVICEHISTORYNOTES", $_servicenote);

$_ir1 = $_POST['ir1'];
$para = $para.FilterNAData(",IR1", $_ir1);

$_ir2 = $_POST['ir2'];
$para = $para.FilterNAData(",IR2", $_ir2);

$_manager = $_POST['manager'];
$para = $para.FilterNAData(",MANAGERIR", $_manager);

$_manufatureIR = $_POST['manufatureIR'];
$para = $para.FilterNAData(",MANUFACTURERIR", $_manufatureIR);

//Connection:
$link = mysqli_connect("localhost", "root", "", 'kimball') or
	die("Could not connect:" . mysqli_error());

//consultation
$query = "UPDATE ".$_datatable." SET ".$para." where JOB_NO=".$_id;

echo $query;
//execute the query
if ($link->query($query) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $link->error;
}
 
$link->close();


function FilterNAData($key, $data)
{
	if($data == 'N/A')
		return "";
	else
		return $key."='".$data."'";
		
}
?>