<?
	include "main_top.php";
	$text1=$_REQUEST["text1"]?$_REQUEST["text1"]: "";
	$page=$_REQUEST["page"]?$_REQUEST["page"]: 1;
	
	$sql="select * from qa where title like '%$text1%' or contents like '%$text1%' order by pos1 desc, pos2"; 

	$args = "text1=$text1";
	$result = mypagination($sql, $args, $count, $pagebar);
	 
	
?>


<div class="row m-1 mb-0 justify-content-center">
	<div class="col" align="center">

		<h4 class="mt-5 mb-3">Q & A</h4>
	
		<hr class="my-0">
		<table class="table table-sm m-0">
			<tr height="35" class="bg-light">
				<td width="10%">번호</td>
				<td width="45%">제목</td>
				<td width="15%" style="transform: translateX(0px);">작성자</td>
				<td width="20%" style="transform: translateX(20px);">작성일</td>
				<td width="10%" style="transform: translateX(0px);">조회</td>
			</tr>
			<?
				foreach ($result as $row){
					$n=strlen($row["pos2"]); //문자열길이 계산
					$title=$row["title"];	
					$id=$row["id"];
			?>
			
			
			<tr height="35">
				<td style="transform: translateX(5px);"><?=$id;?></td>
				<td align="left">
				<?
					if($n==1) {
				?>		
					<a href="qa_read.php?id=<?=$id;?>&page=<?=$page; ?>&text1=<?=$text1; ?>" style="color:#0066CC "><?=$title;?></a><br>
				<?	
					} else {
					for($j=0;$j<$n-2;$j++) {
				?>
					&nbsp;
				<?		
					}
				?>					
					<img src="images/i_re.gif" border="0">
					<a href="qa_read.php?id=<?=$id;?>&page=<?=$page; ?>&text1=<?=$text1; ?>" style="color:#0066CC"><?=$title;?></a><br>
					
				<?		
					}
				?>
					
				</td>
				<td style="transform: translateX(15px);"><?=$row["name"];?></td>
<td style="transform: translateX(0px);"><?=$row["writeday"];?></td>
<td style="transform: translateX(10px);"><?=$row["count"];?></td>

			</tr>
		<?
					}
		?>

		</table>

		<table class="table table-sm table-borderless mt-1 m-0">
			<tr>
				<td align="left">
					<form name="form2" method="post" action="qa.php">
						<div class="d-inline-flex">
							<div class="input-group input-group-sm">
								<span class="input-group-text myfs13">제목+내용</span>
								<input type="text" name="text1" size="10" value=""
									class="form-control bg-light myfs13">
								<button type="button" class="btn btn-sm btn-outline-secondary myfs13" 
									onClick="form2.submit();">검색</button>&nbsp;
							</div>
						</div>
					</form>
				</td>
				<td align="right">
					<a href="qa_new.php" class="btn btn-sm btn-dark text-white myfs13">새글</a>&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	
	</div>
	
<?
	echo $pagebar;
?>

</div>

<br><br><br>

<?
	include "main_bottom.php";
 ?>
