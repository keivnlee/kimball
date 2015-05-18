<?php
	//include the medoo framework
	require_once('medoo.min.php');


	//get the currentpage and search detail
	$page = $_REQUEST['page'];
	$search = $_REQUEST['search'];

	//medoo framework
	$database = new medoo();
	//paging
	//how many adjacent pages should be shown on each side?
	//how many items to show per page
	$adjacents = 3;
	$limite = 5;
	
	//the number of items that satisty the condition
	$total_pages = $database->count('qry_forms_jobs_si_jobs',[
		"OR"=>[
			"JOB_NO[~]"=>"%".$search."%",
			"CUST_NO[~]"=>"%".$search."%",
			"EQUIPMENTTYPE[~]"=>"%".$search."%",
			"MODEL[~]"=>"%".$search."%",
			"SERIALNO[~]"=>"%".$search."%"
			
		]
	]);
	
	if($page)
		$start = ($page - 1) * $limite;
	else
		$start = 0;
	
	//access item in database from $start to $limite
	$datas = $database->select('qry_forms_jobs_si_jobs',[
		"JOB_NO",
		"CUST_NO",
		"EQUIPMENTTYPE",
		"MODEL",
		"SERIALNO"
	],[
		"OR"=>[
			"JOB_NO[~]"=>"%".$search."%",
			"CUST_NO[~]"=>"%".$search."%",
			"EQUIPMENTTYPE[~]"=>"%".$search."%",
			"MODEL[~]"=>"%".$search."%",
			"SERIALNO[~]"=>"%".$search."%"
		],
		"LIMIT"=>[$start, $limite]
	]);
		
	$table = "<table cellspacing='0'><tr>
					<th>Job_No</th>
					<th>Cust_No</th>
					<th>EquipmentType</th>
					<th>Model</th>
					<th>SerialNo</th>
					</tr>";
		
	$count = count($datas);
	for($i = 0; $i < $count; $i++)
	{
		$table.="<tr onclick=\"load_serviceIssueJob_form('".$datas[$i]['JOB_NO']."')\">
				<td>".$datas[$i]['JOB_NO']."</td>
				<td>".$datas[$i]['CUST_NO']."</td>
				<td>".$datas[$i]['EQUIPMENTTYPE']."</td> 
				<td>".$datas[$i]['MODEL']."</td> 
				<td>".$datas[$i]['SERIALNO']."</td>
			</tr>";
	}
	$table .= "</table>";
	echo $table;
	
	
	
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
			$pagination .= "<a href=\"#\" onclick='load_sericeIssueJob_table($prev)'>prev</a>";
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
					$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($counter)'>$counter</a>";					
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
						$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($counter)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($lpm1)'>$lpm1</a>";
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($lastpage)'>$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table(1)'>1</a>";
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table(2)'>2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($counter)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($lpm1)'>$lpm1</a>";
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($lastpage)'>$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table(1)'>1</a>";
				$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table(2)'>2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($counter)'>$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"#\" onclick='load_sericeIssueJob_table($next)'>next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		$pagination.= "</div>\n";		
	}
	
	echo $pagination;
?>