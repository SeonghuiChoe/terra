<?php
  session_start();
?>
<meta charset="utf-8">
<?php
  $userid=$_SESSION["userid"];
  $username=$_SESSION["username"];
  $usernick=$_SESSION["usernick"];
  $table=$_GET["table"];
  $num=$_GET["num"];
  $mode=$_GET["mode"];
  $page=$_GET["page"];
  $subject=$_POST["subject"];
  $content=$_POST["content"];
  $html_ok=$_POST["html_ok"];

  if(!$userid){
    echo("
    <script>
    window.alert('로그인을 하세요');
    history.go(-1);
    </script>
    ");
    exit;
  }

  if(!$subject){
    echo("
    <script>
    window.alert('제목을 입력하세요');
    history.go(-1);
    </script>
    ");
    exit;
  }

  if(!$content){
    echo("
    <script>
    window.alert('내용을 입력하세요');
    history.go(-1);
    </script>
    ");
    exit;
  }

  $regist_day=date("Y-m-d (H:i)");
  include "../lib/dbconn.php";

  if($mode=="modify"){
    $sql="update $table set bq_is_html='$html_ok',bq_subject='$subject', bq_content='$content' where bq_num='$num'";
    mysql_query($sql, $connect);
  }else{
    if($html_ok=="y"){
      $is_html="y";
    }else{
      $is_html="";
      $content=htmlspecialchars($content);//html 쓰기상태가 아니니까 html특수기호들을(<, &같은) &amp;로 변환한다.
    }
    
    //modify가 아니고 response일때
    if($mode=="response"){
      $sql="select * from $table where bq_num=$num";
      $result=mysql_query($sql, $connect);
      $row=mysql_fetch_array($result);
      
      $group_num=$row[bq_group_num];
      $depth=$row[bq_depth]+1;
      $ord=$row[bq_ord]+1;
      
      $sql="update $table set bq_ord=bq_ord+1 where bq_group_num=$group_num and bq_ord > $row[bq_ord]";// bq_ord를 검색해서 클 경우, $bq_ord를 안쓰고 bq_ord+1로도 설정이 가능하다.
      mysql_query($sql, $connect);
      
      $sql="insert into $table (bq_group_num, bq_depth, bq_ord, bq_id, bq_name, bq_nick, bq_subject, bq_content, bq_regist_day, bq_hit, bq_is_html)";
      $sql.=" values($group_num, $depth, $ord, '$userid', '$username', '$usernick', '$subject', '$content', '$regist_day', 0, '$is_html')";
      mysql_query($sql, $connect);
    }else{// 일반 인설트
      $depth=0;
      $ord=0;
      
      $sql="insert into $table(bq_depth, bq_ord, bq_id, bq_name, bq_nick, bq_subject, bq_content, bq_regist_day, bq_hit, bq_is_html)";
      $sql.=" values($depth, $ord, '$userid', '$username', '$usernick', '$subject', '$content', '$regist_day',0,'$is_html')";
      mysql_query($sql, $connect);

      // group_num만 따로 설정
      $sql="select last_insert_id()";// 최근 마지막 자동으로 증가하는(auto_increment)값을 가져와 저장하기(num필드) last_insert_id()라는 함수가 있음.
      $result=mysql_query($sql, $connect);
      $row=mysql_fetch_row($result);// _row가 안되면 _array사용
      $auto_num=$row[0];
      
      $sql="update $table set bq_group_num=$auto_num where bq_num=$auto_num";
      mysql_query($sql, $connect);
    }
  }

  mysql_close();

  echo("
  <script>
  location.href='list.php?table=$table&page=$page';
  </script>
  ");
?>