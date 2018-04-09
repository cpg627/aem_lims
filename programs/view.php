<?php

require_once '../include/layout.inc';

require_once '../db/db.php';



$base = new Layout;

$base->link = '../include/style.css';



$no = $_GET['v'];



if(!isset($no))

{

	header("Content-Type: text/html; charset=UTF-8");

	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";

	exit;

}


//조회된 값의 내용을 리턴해주는 함수
function ThisTable($cate, $pmenu)

{

	while (list($key, $value) = each($pmenu))

	{

		if($cate == $value)

		{

			$cate = $key;

		}

    }

	return $cate;

}

//디자인을 지정해주는 부분
$base->style='

	div.wrap {border:1px solid #ddd;min-height:580px;padding:8px;}

	div.wrap div {padding:8px;}

	div.header{border-top:3px solid #aaa;border-bottom:3px solid #aaa;}

	div.header > h2{margin:0;}

	div.name, div.date, div.os{float:left;}

	div.content{margin-top:20px;}

	div.image {border:1px solid #ddd;text-align:center;}

	div#paging{text-align:center;}

	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}

	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}

	div#paging > a:hover{border:1px solid #ddd;}

	';



$db = new DBC;

//db에 로그인 하는 부분
$db->DBI();







$db->query = "select no, id, date, time, category, title, content, link, OS, korean, image, licence from programs where no=".$no." limit 0, 1";

$db->DBQ();



$data = $db->result->fetch_row();

if(!isset($data))

{

	header("Content-Type: text/html; charset=UTF-8");

	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";

	exit;

}

switch($data[11])

{

	case 1:

		$licence='페이웨어 : 개인, 기업 유료';

		break;

	case 2:

		$licence='부분적 프리웨어 : 개인 무료, 기업 유료';

		break;

	case 3:

		$licence='프리웨어 : 개인, 기업 무료';

		break;

	case 4:

		$licence='쉐어웨어 : 일정기간 이후 유료';

		break;

	case 5:

		$licence='부분적 쉐어웨어 : 개인 메일 인증 시 무료, 기업 유료';

		break;

	default:

		$licence='페이지 오류입니다.';

		break;

}



$cate = ThisTable($data[4], $base->$pmenu);



	$base->content = $base->content."

		<div class='wrap'>

			<div class='header'><h2>".$data[5]."</h2></div>

			<div class='name'><b>".$data[1]."</b></div>

			<div class='date'>".$data[2]." ".$data[3]."</div>

			<div class='category'>카테고리 : <a href='./?tn=".$data[4]."'>".$cate."</a></div>

			<div class='os'>OS : ".$data[8]."</div>

			<div class='kr'>한국어 지원 : ".$data[9]."</div>

			<div>".$licence."</div>

			<div class='link'>다운로드 페이지 : <a href='".$data[7]."' target='_blank'>연결하기</a></div>

			<div class='image'><img class='maxwidth' src='.".$data[10]."'/></div>

			<div class='content'>".nl2br($data[6])."</div>

		</div>";



$base->LayoutMain();

?>