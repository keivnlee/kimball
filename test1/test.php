<?php
$pdf_file = escapeshellarg( "test.pdf" );
$jpg_file = escapeshellarg( "test.jpg" );

$result = 0;
new imagick(); 
exec('convert -density 300 test.pdf test.png');
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>

<script type="text/javascript">
    <!--

    function MM_openBrWindow(theURL,winName,features) { //v2.0
        window.open(theURL,winName,features);
    }
    //-->
</script>
<body>

	<img src=<?php echo $jpg_file?> alt="Smiley face" height="42" width="42">

</body>
</html>