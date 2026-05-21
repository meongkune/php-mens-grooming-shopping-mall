<?
include "main_top.php";

$text1=$_REQUEST["text1"] ?? "";
$page=$_REQUEST["page"] ?? 1;

$sql="select * from qa where title like '%$text1%' or contents like '%$text1%' order by pos1 desc, pos2";
$args = "text1=$text1";
$result = mypagination($sql, $args, $count, $pagebar);
?>

<div class="clean-page">
	<div class="clean-head">
		<h4>Q &amp; A</h4>
		<p>상품과 주문에 대한 문의를 남기고 답변을 확인하세요.</p>
	</div>

	<div class="clean-card">
		<div class="clean-board-toolbar">
			<form name="form2" method="post" action="qa.php" class="clean-form">
				<div class="input-group">
					<span class="input-group-text">제목+내용</span>
					<input type="text" name="text1" value="<?=$text1;?>" class="form-control" style="max-width:260px">
					<button type="button" class="btn clean-btn clean-btn-secondary" onClick="form2.submit();">검색</button>
				</div>
			</form>
			<a href="qa_new.php" class="btn clean-btn clean-btn-primary">글쓰기</a>
		</div>

		<div class="table-responsive">
			<table class="clean-board-table">
				<thead>
					<tr>
						<th width="10%">번호</th>
						<th>제목</th>
						<th width="16%">작성자</th>
						<th width="16%">작성일</th>
						<th width="10%">조회</th>
					</tr>
				</thead>
				<tbody>
				<?
				foreach ($result as $row){
					$n=strlen($row["pos2"]);
					$title=$row["title"];
					$id=$row["id"];
					$is_reply = ($n != 1);
				?>
					<tr>
						<td class="text-center"><?=$id;?></td>
						<td>
							<? if ($is_reply) { ?><span class="me-2 text-muted">↳</span><? } ?>
							<a href="qa_read.php?id=<?=$id;?>&page=<?=$page; ?>&text1=<?=$text1; ?>" class="clean-board-title">
								<?=htmlspecialchars($title);?>
							</a>
						</td>
						<td class="text-center"><?=$row["name"];?></td>
						<td class="text-center"><?=$row["writeday"];?></td>
						<td class="text-center"><?=$row["count"];?></td>
					</tr>
				<?
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="mt-3">
		<?=$pagebar;?>
	</div>
</div>

<br><br><br>

<?
include "main_bottom.php";
?>
