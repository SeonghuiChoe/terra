<?
include("./board_rv_su_h.php");
 include _BASE_DIR."/common.php"; 
$table=$_GET["table"];
$br_num=$_GET["br_num"];
$page=$_GET["page"];
$userid=$_SESSION["userid"];
$userlevel=$_SESSION["userlevel"];
$upload_dir=_BASE_DIR."/data/";
$upload_dir2=$cfg[url]."/data/";

$ripple="br_re";

if ( !$br_num ) {
	echo("
	<script>
	history.go(-1);
	</script>
	");
	exit;
}

$sql="SELECT * FROM $table WHERE br_num=$br_num";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$item_num=$row[br_num];
$item_id=$row[id];
$item_name=$row[br_name];
$item_hit=$row[br_hit];

$image_name[0]=$row[br_img_0];
$image_name[1]=$row[br_img_1];
$image_name[2]=$row[br_img_2];

$image_copied[0]=$row[br_copied_0];
$image_copied[1]=$row[br_copied_1];
$image_copied[2]=$row[br_copied_2];

$item_reg_date=$row[br_reg_date];
$item_title=str_replace(" ","&nbsp;", $row[br_title]);
$item_content=$row[br_content];
$is_html=$row[br_is_html];

if($is_html!="y") {
	$item_content=str_replace(" ","&nbsp;",$item_content);
	$item_content=str_replace("\n","<br>",$item_content);
}

for($i=0; $i<3; $i++) {
	if($image_copied[$i]) {
		$imageinfo=GetImageSize($upload_dir.$image_copied[$i]);// 배열로 크기와 형식을 반환
		$image_width[$i]=$imageinfo[0];
		$image_height[$i]=$imageinfo[1];
		$image_type[$i]=$imageinfo[2];
		if($image_width[$i]>600) {
			$image_width[$i]=600;
		}
	} else {
		$image_width[$i]="";
		$image_height[$i]="";
		$image_type[$i]="";
	}
}

$new_hit=$item_hit+1;
$sql="UPDATE $table SET br_hit=$new_hit WHERE br_num=$br_num";
mysql_query($sql, $connect);

?>
<script>
function check_input() {
	if(!document.ripple_form.ripple_content.value) {
		alert("덧글 내용을 입력해주세요.");
		document.ripple_form.ripple_content.focus();
		return;
	}
	document.ripple_form.submit();
}
function del(href) {
	if(confirm("선택한 글을 삭제하시겠습니까?")) {
	document.location.href=href;
	}
}
</script>
<script>
$(function() {
	$('#remaining').each(function() {
		var count = $("#count", this);
		var max = $("#max", this);
		var maximumCount = count.text() * 1;
		var maximumNumber = max.text() * 1;
		var input = $(this).prev();

		var update = function() {
			var before = count.text() * 1;
			var now = maximumCount + input.val().length;
			if (now > maximumNumber) {
				var str = input.val();
				alert('덧글 입력수가 초과하였습니다.');
				input.val(str.substring(maximumNumber, 1));
			}
			if (before != now) {
				count.text(now);
			}
		};
		input.bind('input keyup paste', function() {
			setTimeout(update, 0)
		});
			update();
	});
});
</script>
<div class="view_form">
	<table>
		<tr>
			<th><h3><?=$item_title?></h3></th>
		</tr>
		<tr>
			<td><span><?echo "$item_name($item_id)" ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;조회수&nbsp;&nbsp;:&nbsp;&nbsp;<?=$item_hit?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;등록일&nbsp;&nbsp;:&nbsp;&nbsp;<?=$item_reg_date?></span></td>
		</tr>	
		<tr>
			<td>
			<?
				for($i=0; $i<3; $i++) {
					if($image_copied[$i]) {
						$img_name=$image_copied[$i];
						$img_name=$upload_dir2.$img_name;
						$img_width=$image_width[$i];
						echo "<img src='$img_name' width='$img_width'>"."<br /><br />";
					}
				}
			?>
			<?=$item_content?>
			<td>
		</tr>
	</table>
</div>
	<br />
	<br />
	<div id="ripple">
		<div id="ripple2">
			<?
			$sql="SELECT * FROM $ripple WHERE br_re_parent='$item_num'";
			$ripple_result=mysql_query($sql);

			while($row_ripple=mysql_fetch_array($ripple_result)) {
				$ripple_num=$row_ripple[br_re_num];
				$ripple_id=$row_ripple[id];
				$ripple_name=$row_ripple[br_re_name];
				$ripple_content=htmlspecialchars($row_ripple[br_re_content]);
				$ripple_content=nl2br($ripple_content);
				$ripple_date=$row_ripple[br_re_reg_date];
			?>
		<div id="ripple_title">
			<ul>
				<li><?echo"$ripple_name($ripple_id)"?> &nbsp;|&nbsp; <?=$ripple_date ?></li>
				<li id="ripple_del">
				<?
					if($userlevel==10 || $userid==$ripple_id){ ?>
					<a href="javascript:del('re_delete.php?table=<?=$table?>&br_num=<?=$item_num?>&br_re_num=<?=$ripple_num?>&page=<?=$page?>')">[덧글 삭제]</a>
				<?}?>
				</li>
			</ul>
		</div><!-- ripple_title end -->
		<div id="ripple_content"><?=$ripple_content?></div>
			<?
			}// while end
			mysql_close();
			?>
			<div id="ripple_form">
				<form name="ripple_form" method="post" action="re_insert.php?table=<?=$table?>&ripple=<?=$ripple?>&br_num=<?=$item_num?>&page=<?=$page?>">
					<div id="ripple_insert">
						<div id="ripple_textarea" class="text">
							<textarea id="ripple_content" name="ripple_content"></textarea><span id="remaining">(<span id="count">0</span>/<span id="max">300</span>)</span>
						</div>
						<div id="ripple_button">
							<a href="javascript:check_input()">덧글 쓰기</a>
						</div>
					</div><!-- ripple_insert end -->
				</form>
			</div>
		</div> <!-- ripple2 end -->
	</div> <!-- ripple end -->
	<br />
	<div id="button">
		<a href="list.php?table=<?=$table?>&page=<?=$page?>">목록보기</a>
		<?
			if( $userlevel==10 || $userid==$item_id ) {
		?>
		<a href="write.php?table=<?=$table?>&mode=modify&br_num=<?=$br_num?>&page=<?=$page?>">수정하기</a>
		<a href="javascript:del('delete.php?table=<?=$table?>&br_num=<?=$br_num?>&page=<?=$page?>')">삭제하기</a>
		<?
			}
			if($userid) {
		?>
		<!--<a href="write.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>-->
		<?
			}
		?>
	</div>
<?
include("./board_rv_su_f.php");
?>