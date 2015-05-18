<?php

	//include the medoo framework
	require_once('medoo.min.php');

	//get the current page and search detail
	$search = $_REQUEST['search'];
	$page = $_REQUEST['page'];
	
	//MEDOO framework
	$database = new medoo();
	
	// How many adjacent pages should be shown on each side.
	// How many items to show per page.
	$adjacent = 3;
	$limit = 5;
	
	//the number of items that satisfy the condition
	$total_pages = $database->count('QRY_FORMS_JOBS',[
		"OR"=>[
			"JOB_NO[~]"=>"%".$search."%",
			"CUST_NO[~]"=>"%".$search."%",
			"ORD_DATE[~]"=>"%".$search."%",
			"EQUIPMENTTYPE[~]"=>"%".$search."%",
			"MODEL[~]"=>"%".$search."%",
			"SERIALNO[~]"=>"%".$search."%"
		]
	]);
	
	if($page)
		$start = ($page - 1) * $limit;
	else
		$start = 0;
	
	//access item in database from $start to $limit
	$data = $database->select('QRY_FORMS_JOBS',[
		"JOB_NO",
		"CUST_NO",
		"ORD_DATE",
		"EQUIPMENTTYPE",
		"MODEL",
		"SERIALNO"
	],[
		"OR"=>[
			"JOB_NO[~]"=>"%".$search."%",
			"CUST_NO[~]"=>"%".$search."%",
			"ORD_DATE[~]"=>"%".$search."%",
			"EQUIPMENTTYPE[~]"=>"%".$search."%",
			"MODEL[~]"=>"%".$search."%",
			"SERIALNO[~]"=>"%".$search."%"
		],
		"LIMIT"=>[$start, $limit]
	]);
	
	$table = "<table cellspacing='0'><tr>
			<th>Job No</th>
			<th>Cust No</th>
			<th>Ord Date</th>
			<th>EquipmentType</th>
			<th>Model</th>
			<th>SserialNo</th>
			</tr>";
			
	$count = count($data);
	for($i = 0; $i < $count; $i++)
	{
		$table.="<tr onclick=\"load_job_form('".$data[$i]['JOB_NO']."', '".$data[$i]['CUST_NO']."')\">
				<td>".$data[$i]['JOB_NO']."</td>
				<td>".$data[$i]['CUST_NO']."</td>
				<td>".$data[$i]['ORD_DATE']."</td>
				<td>".$data[$i]['EQUIPMENTTYPE']."</td>
				<td>".$data[$i]['MODEL']."</td>
				<td>".$data[$i]['SERIALNO']."</td>
			</tr>";
	}
	$table .="</table>";
	echo $table;
	
	
	//Setup page vars for display
	$prev = $page - 1;
	$next = $page + 1;
	$last_page = ceil($total_pages/$limit);
	$lpm1 = $last_page - 1;
	$pagination = "";	

	if($last_page > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination .= "<a href='#' onclick='load_job_table($prev)'>prev</a>";
		else
			$pagination .= "<span class=\"disabled\">prev</span>";	
		
		//pages	
		if ($last_page < 7 + ($adjacent * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $last_page; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href='#' onclick='load_job_table($counter)'>$counter</a>";					
			}
		}
		elseif($last_page > 5 + ($adjacent * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacent * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacent * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href='#' onclick='load_job_table($counter)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href='#' onclick='load_job_table($lpm1)'>$lpm1</a>";
				$pagination.= "<a href='#' onclick='load_job_table($last_page)'>$last_page</a>";
			}
			//in middle; hide some front and some back
			elseif($last_page - ($adjacent * 2) > $page && $page > ($adjacent * 2))
			{
				$pagination.= "<a href='#' onclick='load_job_table(1)'>1</a>";
				$pagination.= "<a href='#' onclick='load_job_table(2)'>2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacent; $counter <= $page + $adjacent; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href='#' onclick='load_job_table($counter)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href='#' onclick='load_job_table($lpm1)'>$lpm1</a>";
				$pagination.= "<a href='#' onclick='load_job_table($last_page)'>$last_page</a>";
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href='#' onclick='load_job_table(1)'>1</a>";
				$pagination.= "<a href='#' onclick='load_job_table(2)'>2</a>";
				$pagination.= "...";
				for ($counter = $last_page - (2 + ($adjacent * 2)); $counter <= $last_page; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href='#' onclick='load_job_table($counter)'>$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href='#' onclick='load_job_table($next)'>next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		$pagination.= "</div>\n";		
	}
	
	echo $pagination;
?>