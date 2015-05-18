<html>
<head>
<title>Paging Using PHP</title>

<style>
div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;
	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #000099;	
	font-weight: bold;
	background-color: #000099;
	color: #FFF;
}
div.pagination span.disabled {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;	
	color: #DDD;
}
table{
	table-layout:fixed;
	width:600px;
	height:400px;
	border:1px solid;
	word-wrap:break-word;
}

#content{
	position: fixed;
	top: 0;
	left: 0;
	width:100%;
	height:100%;
	opacity:.95;
	display:none;
	position:fixed;
	background-color:#313131;
	overflow:auto
}
#contentform{
	position:absolute;
	left:50%;
	top:50%;
	width:800px;
	height:550px;
	margin-top: -15em; /*set to a negative number 1/2 of your height*/
	margin-left: -25em; /*set to a negative number 1/2 of your width*/
	border: 1px solid rgb(140,27,27);
 	background-color: #ebe8e2;
}
#Rcontent span{
	width:266px;
	
}
	
</style>
<script type="text/javascript">
	function loadTable(p)
	{
		var vars;
		var page = p;
		var search = "";
		var searchbar = document.getElementById("searchBar");
		
		if(searchbar != null)
		{
			search = searchbar.value;
			console.log(search);
		}		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("table").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "table.php?search="+search+"&page="+page, true);
		xmlhttp.send();
		
	}

	function LoadIDItem(it1, it2)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
				document.getElementById("contentform").innerHTML = xmlhttp.responseText;
		}
		
		xmlhttp.open("GET", "form.php?it1="+it1+"&it2="+it2, true);
		xmlhttp.send();
		document.getElementById('content').style.display = "block";
	}
		
	function cancle()
	{
		document.getElementById('content').style.display = "none";
	}
</script>
</head>
<body>
<script type="text/javascript">
	loadTable(1);
</script>
<input id="searchBar" type='text' size='30' onkeyup='loadTable(1)' placeholder='search'><br><br>
<div id="table">
	
</div>

<div id="content">
	<div id="contentform">
	</div>
</div>
	
</body>