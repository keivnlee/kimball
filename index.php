<?PHP
include_once 'includes/functions.php';
	// if user doesn't log in.
	//session_start();
	sec_session_start();
	if (!login_check()) {
		header ("Location: login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/index_support.js"></script>
<script type="text/javascript">
    function MM_openBrWindow(theURL) { //v2.0
        window.open(theURL, 'google', 'width = 1000, height=600;');
    }
</script>
<link rel="stylesheet" type="text/css" href="css/pagination.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" type="text/css" href="css/job_detail.css">
<link rel="stylesheet" type="text/css" href="css/tab_content.css"/>
</head>

<body>
<div id="container">
    <!-- kimball logo-->
    <div style="background-image: url('http://www.kimballequipment.com/wp-content/uploads/2014/08/kimball-logo-black-font-325.png'); height: 59px; width: 329px; margin-left:5px;float:left;">
    </div>

    <!-- navigation bar-->
	<div id="nav">
		<ul>	
			<li><a href="#" onclick="load_job_table(1)">All Jobs</a></li>
			<li><a href="#" onclick="load_serviceIssueJob_table(1)" >Service Issue jobs</a></li>
			<li><a href="#" onclick="load_serviceIssue_table(1)">Service Issues</a></li>
			<li><a href='logout.php'>Log out</a></li>
		</ul>
	</div>

    <!-- middle bar for decoration-->
	<div style='border:1px;width:100%;height:7px;background-color:rgb(140,27,27);float:left;margin-top:3px;'>
	</div>

    <!-- main table -->
	<div id="body">
		<div id = "sections">

			<div id="job_detail_jobs"  class="detail" style="text-align:center">
				<input id="job_searchBar" type='search' onkeyup='load_job_table(1)'>
				<div id="job_table">
				</div>
			</div>
			
			<div id="serviceIssueJobs_detail" class="detail" style="text-align:center">
				<input id="serviceIssueJobs_searchBar" type='search' onkeyup='load_serviceIssueJob_table(1)'>
				<div id="serviceIssueJobs_table">
				</div>
			</div>

			<div id="serviceIssue_detail" class="detail" style="text-align:center">
				<input id="serviceIssue_searchBar" type='search' onkeyup='load_serviceIssue_table(1)'>
				<div id="serviceIssue_table">
				</div>
			</div>

        <!-- content page of individual data item-->
			<div id="content">
				<div id="contentform">
				</div>
			</div>

		</div>
	</div>
</div>

</body>
</html>
