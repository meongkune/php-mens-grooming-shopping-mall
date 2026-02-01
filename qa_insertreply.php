<?
	include "common.php";
	
	
	$id=$_REQUEST["id"];
	$pos1=$_REQUEST["pos1"];
	$pos2=$_REQUEST["pos2"];
	$passwd=$_REQUEST["passwd"];
	
	$title = addslashes($_REQUEST["title"]);
	
	$name=$_REQUEST["name"];
	$passwd=$_REQUEST["passwd"];
	
	$contents = addslashes($_REQUEST["contents"]);
	
	$sql="select pos2, right(pos2,1) as last_char from qa
		  where pos1=$pos1 and length(pos2)=length('$pos2')+1 and
			  locate('$pos2',pos2)=1
		  order by pos2 desc limit 1";
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");		  
		  
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		$row=mysqli_fetch_array($result);
		$last_char = $row["last_char"];
		$new_char= chr(ord($last_char)+1);
		$new_pos2=$pos2.$new_char;
		
	}
	else
		$new_pos2 = $pos2 . "A";
	
	$writeday=date("Y-m-d");
	
	$sql = "INSERT INTO `qa`(`pos1`, `pos2`, `title`, `name`, `passwd`, `writeday`, `count`, `contents`) 
		    VALUES ($pos1,'$new_pos2','$title','$name','$passwd','$writeday',0,'$contents')";		
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");		
	
	echo("<script>location.href='qa.php'</script>");
	
?>