<?php
	//include the medoo framework
	require_once 'includes/db_connect.php';
	
	
	//get the currentpage and search detail
	$page = $_REQUEST['page'];
	$search = $_REQUEST['search'];
	
	//paging
	//how many adjacent pages should be shown on each side?
	//how many items to show per page
	$adjacents = 3;
	$limite = 5;
	
	//the number of items that satisfy the condition
	$total_pages = $database->count('TBL_JOBS_SI',[
		"OR"=>[
			"SI[~]"=>"%".$search."%",
			"IR1[~]"=>"%".$search."%",
			"IR2[~]"=>"%".$search."%",
			"IRMANAGER[~]"=>"%".$search."%",
			"IRMANUFACTURER[~]"=>"%".$search."%"
		      ]
	]);
					
	if($page)
		$start = ($page - 1) * $limite;
	else
		$start = 0;
		
	$datas = $database->select('TBL_JOBS_SI',[
		"SI",
		"IR1",
		"IR2",
		"IRMANAGER",
		"IRMANUFACTURER"
	],[
		"OR"=>[
			"SI[~]"=>"%".$search."%",
			"IR1[~]"=>"%".$search."%",
			"IR2[~]"=>"%".$search."%",
			"IRMANAGER[~]"=>"%".$search."%",
			"IRMANUFACTURER[~]"=>"%".$search."%"
		],
		"LIMIT"=>[$start, $limite]
	]);
		
	$table = "<table cellspacing='0'><tr>
					<th>SI</th>
					<th>IR1</th>
					<th>IR2</th>
					<th>IRManager</th>
					<th>IRManufacturer</th>
					</tr>";
	$count = count($datas);	
	for($i=0; $i < $count; $i++)
	{
		$table.="<tr onclick=\"load_serviceIssue_form('".$datas[$i]['SI']."', '".$datas[$i]['IR1']."', '".$datas[$i]['IR2']."')\">
			 <td>".$datas[$i]['SI']."</td>
			 <td>".$datas[$i]['IR1']."</td> 
			 <td>".$datas[$i]['IR2']."</td>
			 <td>".$datas[$i]['IRMANAGER']."</td>
			 <td>".$datas[$i]['IRMANUFACTURER']."</td>
			</tr>"; 
		
	}
	$table .="</table>";
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
			$pagination .= "<a href=\"#\" onclick='load_serviceIssue_table($prev)'>prev</a>";
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
					$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($counter)'>$counter</a>";					
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
						$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($counter)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($lpm1)'>$lpm1</a>";
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($lastpage)'>$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table(1)'>1</a>";
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table(2)'>2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($counter)'>$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($lpm1)'>$lpm1</a>";
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($lastpage)'>$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table(1)'>1</a>";
				$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table(2)'>2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($counter)'>$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"#\" onclick='load_serviceIssue_table($next)'>next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		$pagination.= "</div>\n";		
	}
	
	echo $pagination;
	
?>