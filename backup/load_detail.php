<?php
	//take the parameters from the web link
	$page = $_REQUEST['page'];
	
	$id = $_REQUEST['id'];
	
	$search = $_REQUEST['search'];
	$search = empty($search) ? " ": $search;
	$sqltable = null;
	
	switch($id)
	{
		case "serviceIssueJobs_detail": 
			$sqltable = 'qry_forms_jobs_si_jobs';
			break;
		case "serviceIssue_detail":	
			$sqltable = 'TBL_JOBS_SI';
			break;
	}
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	//how many items to show per page
	$limite = 5;
	
	//Connection:
	$link = mysqli_connect("localhost", "root", "", 'kimball') or
		die("Could not connect:" . mysqli_error());
	
	//consultation
	$query = "";
	switch($id)
	{
		case "serviceIssueJobs_detail": 
			$query = "Select count(*) from ".$sqltable." where JOB_NO like '%$search%' or CUST_NO like '%$search%' or EQUIPMENTTYPE like '%$search%' or MODEL like '%$search%' or SERIALNO like '%$search%'";
			break;
		case "serviceIssue_detail":	
			$query = "Select count(*) from ".$sqltable." where (SI like '%$search%' or IR1 like '%$search%' or IR2 like '%$search%')";
			break;
	}
	
	//execute the query
	$result = mysqli_query($link, $query);
	
	if(!$result)
		die('Could not get data:'.mysqli_error($link));

	$total_pages = mysqli_fetch_array($result, MYSQL_NUM);
	$total_pages = $total_pages[0];

	if($page)
		$start = ($page - 1) * $limite;
	else
		$start = 0;
	
	
	/* Get data.*/
	switch($id)
	{
		case "serviceIssueJobs_detail": 
			$query = "Select * from ".$sqltable." where (JOB_NO like '%$search%' or CUST_NO like '%$search%' or EQUIPMENTTYPE like '%$search%' or MODEL like '%$search%' or SERIALNO like '%$search%')"." LIMIT $start, $limite";
			break;
		case "serviceIssue_detail":	
			$query = "Select * from ".$sqltable." where (SI like '%$search%' or IR1 like '%$search%' or IR2 like '%$search%')"." LIMIT $start, $limite";
			break;
	}
	//$query = "select * from ".$sqltable." LIMIT $start, $limite";
	$result = mysqli_query($link, $query);
	
	if(!$result )
	{
	  die('Could not get data: ' . mysqli_error($link));
	}
	
	
	switch($id)
	{
		case "serviceIssue_detail":
		{
			$table = "<table cellspacing='0'><tr>
					<th>IR</th>
					<th>IR1</th>
					<th>IR2</th>
					<th>IRManager</th>
					<th>IRManufacturer</th>
					</tr>";
			
			
			while($row = mysqli_fetch_array($result))
			{
				$table.="<tr onclick=\"load_serviceIssue_form('$row[0]', '$row[4]', '$row[5]')\"><td>$row[0]</td>";
				$table.="<td>$row[4]</td> 
					 <td>$row[5]</td>
					 <td>$row[6]</td>
					 <td>$row[7]</td>
					</tr>";
			}
			$table .="</table>";
	
			echo $table;
		}
		break;
		case "serviceIssueJobs_detail":
		{
			$table = "<table cellspacing='0'><tr>
					<th>Job_No</th>
					<th>Cust_No</th>
					<th>EquipmentType</th>
					<th>Model</th>
					<th>SerialNo</th>
					</tr>";
			
			
			while($row = mysqli_fetch_array($result))
			{
				$table.="<tr onclick=\"load_serviceIssueJob_form('$row[0]')\"><td>$row[0]</td>";
				$table.="<td>$row[1]</td> <td>$row[2]</td> <td>$row[3]</td> <td>$row[4]</td></tr>";
			}
			$table .="</table>";
	
			echo $table;
		}
		break;
	}
	

	
	//Setup page vars for display
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limite);
	$lpm1 = $lastpage - 1;		

	$pagination = "";	

	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination .= "<a href=\"#\" onclick='LoadDetail($prev, $id)'>prev</a>";
		else
			$pagination .= "<span class=\"disabled\">prev</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"#\" onclick='LoadDetail($counter, $id)'>$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='LoadDetail($counter, $id)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"#\" onclick='LoadDetail($lpm1, $id)'>$lpm1</a>";
				$pagination.= "<a href=\"#\" onclick='LoadDetail($lastpage, $id)'>$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"#\" onclick='LoadDetail(1, ‘$id)'>1</a>";
				$pagination.= "<a href=\"#\" onclick='LoadDetail(2, $id)'>2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='LoadDetail($counter, $id)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"#\" onclick='LoadDetail($lpm1, $id)'>$lpm1</a>";
				$pagination.= "<a href=\"#\" onclick='LoadDetail($lastpage, $id)'>$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"#\" onclick='LoadDetail(1, $id)'>1</a>";
				$pagination.= "<a href=\"#\" onclick='LoadDetail(2, $id)'>2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='LoadDetail($counter, $id)'>$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"#\" onclick='LoadDetail($next, $id)'>next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		$pagination.= "</div>\n";		
	}
	
	echo $pagination;
	
	mysqli_close($link);
?>