<?php
require_once '../include/layout.inc';

require_once '../db/db.php';


/*error Message 출력하는 구문*/
error_reporting(E_ALL);

ini_set("display_errors", 1);



$base = new Layout;



$base->link = '../include/style.css';



$db = new DBC;

$db->DBI(); //DB에 접속



$id = $_POST['logid'];

$pass = $_POST['logpass'];



$db->query = "select id, pass, permit from member where id='".$id."' and pass=password('".$pass."')";

$db->DBQ(); //쿼리 전송



$num = $db->result->num_rows; //쿼리 결과값 갯수를 확인

$data = $db->result->fetch_row(); //결과값 호출



$db->DBO();



if($num==1)

{
    
    $_SESSION['id'] = $id;
    
    $_SESSION['permit'] = $data[2];
    
    echo "<script>location.replace('/aem_lims/programs');</script>";
    
} else if(($id!="" || $pass!="") && $data[0]!=1)

{
    
    echo "<script>alert('아이디와 비밀번호가 맞지 않습니다.');</script>";
    
}



$base->content = "
    
<form action='".$_SERVER['PHP_SELF']."' method='post'>
    
	<table style='margin:0 auto; margin-top:5%;'>
    
		<tr>
    
			<th colspan='2'>로그인</th>
    
		</tr>
    
		<tr>
    
			<td><input type='text' name='logid'size='16' placeholder='아이디'/></td>
    
			<td rowspan='2'><input type='submit' value='로그인' style='height:50px;'/></td>
    
		</tr>
    
		<tr>
    
			<td><input type='password' name='logpass' size='16' placeholder='비밀번호'/></td>
    
		</tr>
    
		<tr>
    
			<td><a href='./registi.php'>등록</a></td>
    
			<td style='text-align:right;'><a href='./find.php'>찾기</a></td>
    
		</tr>
    
	</table>
    
</form>
    
";



$base->LayoutMain();



?>