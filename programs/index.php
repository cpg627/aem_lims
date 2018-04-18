<?php

include_once "../include/layout.inc"; // 레이아웃을 include 함
require_once '../db/db.php';

/*error Message 출력하는 구문*/
error_reporting(E_ALL);

ini_set("display_errors", 1);




$base = new Layout;

$base->link = '../include/style.css';



$tn=$_GET['tn'];

$onepage=3;


if($_GET['p']==false)

{
    
    $_GET['p']=1;
    
}


$db = new DBC;

$db->DBI();



if($tn=='') //programs 메인

{
    
    $base->style='
        
	div.left {padding:1%; width:48%;}
        
	div.right { padding:1%; width:48%;}
        
	div.wrap {margin:3% 0; box-sizing:border-box; border:1px solid #ddd; min-height:150px;padding:4%; min-width:300px; width100%;}
        
	div.wrap div {text-align:center;padding:1% 0;}
        
	div.content{margin-top:20px;}
        
	div.paging{text-align:center;}
        
	div.image > div {text-align:center;}
        
	div.image > div  img {min-witdth:300px;width:100%; max-width:100%;}
        
	div.header > h1 {font-size:2em;margin:2% 1%;}
        
	';
    
    
    
    $base->content = "<div class='header'><h1>내용 표시 부분</h1></div>";
    
    $left = $left."<div class='left' style='float:left'>";
    
    $right = $right."<div class='right' style='float:right'>";


    while (list($key, $value) = each($base->pmenu)) //$base는 각 Side 표시 메뉴의 서식을 결정해준다.
    
    {

        $db->query = "select no, date, category, title, os, image, licence from programs where category='".$value."' order by no desc limit 0, 1";/* no으로 정렬을 인기순으로 */
        
        $db->DBQ();
        
        $data=$db->result->fetch_row();
        
        echo "value :: ".$value." ::";
        echo "data :: ".$data[6]." ::";
        
        
        switch($data[6])
        
        {
            
            case Request:
                
                $licence='분석의뢰 완료';
                
                break;
                
            case View:
                
                $licence='분석중';
                
                break;
                
            case Status:
                
                $licence='분석완료';
                
                break;
                
                
            default:
                $licence='오류 발생';
                
                break;
                
        }
        
        
        
        if($data!='')
        
        {
            
            
            
            if($num==0)
            
            {
                
                $num=1;
                
                $left = $left."
                    
				<div class='wrap'>
                    
					<div class='image'><div><a href='./view.php?v=".$data[0]."'></div></div>
					    
					<div class='header'><a href='./view?v=".$data[0]."'>".$data[3]."</a></div>
					    
					<div class='category'>카테고리 : <a href='./?tn=".$data[2]."'>".$key."</a></div>
					    
					<div class='date'>".$data[1]."</div>
					    
					<div class='os'>OS : ".$data[4]."</div>
					    
					<div class='licence'>진행상태 : ".$licence."</div>
					    
				</div>";
                
            } else
            
            {
                
                $num=0;
                
                $right = $right."
                    
				<div class='wrap'>
                    
					<div class='image'><div><a href='./view.php?v=".$data[0]."'></div></div>
					    
					<div class='header'><a href='./view?v=".$data[0]."'>".$data[3]."</a></div>
					    
					<div class='category'>카테고리 : <a href='./?tn=".$data[2]."'>".$key."</a></div>
					    
					<div class='date'>".$data[1]."</div>
					    
					<div class='os'>OS : ".$data[4]."</div>
					    
					<div class='licence'>라이센스 : ".$licence."</div>
					    
				</div>";
                
            }
            
        }
        
    }
    
    $left = $left."</div>";
    
    $right = $right."</div>";
    
    
    
    $base->content=$base->content.$left.$right."<div style='clear:both'></div>";
    
} else if($tn=='latest') //latest 부분

{
    
    $db->query = "select count(*) from programs";
    
    $db->DBQ();
    
    $quantity = $db->result->fetch_row();
    
    
    
    $limit=$onepage*$_GET['p']-$onepage;
    
    
    
    $db->query = "select no, id, date, time, category, title, content, link, os, korean, image, licence from programs order by no desc limit ".$limit.", ".$onepage;
    
} else

{	$db->query = "select count(*) from programs where category='".$tn."'";

$db->DBQ();

$quantity = $db->result->fetch_row();



$limit=$onepage*$_GET['p']-$onepage;







$db->query = "select no, id, date, time, category, title, content, link, os, korean, image, licence from programs where category='".$tn."' order by no desc limit ".$limit.", ".$onepage;

}



if($tn!='')

{
    
    $base->style='
        
	div.wrap {margin-bottom:10px;border:1px solid #ddd;min-height:400px;padding:8px;}
        
	div.wrap div {padding:8px;}
        
	div.left {float:left;width:50%;}
        
	div.right {float:right;width:40%;width:43%;}
        
	div.header{border-top:3px solid #aaa;border-bottom:3px solid #aaa;}
        
	div.header > h2{margin:0;}
        
	div.content{border:1px solid #ddd;margin-top:10px;min-height:170px;}
        
	div.image {text-align:center;min-height:316px;}
        
	img{max-height:330px;}
        
	div#paging{text-align:center;}
        
	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}
        
	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}
        
	div#paging > a:hover{border:1px solid #ddd;}
        
	';
    
    
    
    $db->DBQ();
    
    while($data = $db->result->fetch_row())
    
    {
        
        while (list($key, $value) = each($base->pmenu))
        
        {
            
            if($data[4] == $value)
            
            {
                
                $cate = $key;
                
            }
            
        }
        
        
        
        $base->content = $base->content."
            
		<div class='wrap'>
            
			<div class='header'><h2><a href='./view.php?v=".$data[0]."'>".$data[5]."</a></h2></div>
			    
			<div class='left'>
			    
				<div class='name'><b>".$data[1]."</b></div>
				    
				<div class='date'>".$data[2]."</div>
				    
				<div class='category'>카테고리 : <a href='./?tn=".$data[4]."'>".$cate."</a></div>
				    
				<div class='link'>다운로드 페이지 : <a href='".$data[7]."' target='_blank'>연결하기</a></div>
				    
				<div class='content'>".nl2br($data[6])."</div>
				    
			</div>
				    
			<div class='right'>
				    
				<div class='image'><a href='./view.php?v=".$data[0]."'><img class='maxwidth' src='.".$data[10]."'/></a></div>
				    
			</div>
				    
		</div>";
        
    }
    
    
    
    $thispage = $_GET['p']; //현재 페이지
    
    $totalpage=(int)ceil ($quantity[0]/$onepage); //전체 페이지
    
    $oneblock = 10; //페이지 블록 한 페이지에 몇개 보일지.
    
    if($thispage>$totalpage)
    
    {
        
        echo "<script>alert('존재하지 않는 페이지입니다.');location.replace('./');</script>";
        
    }
    
    
    
    
    
    $thisblock = (int)(ceil($thispage/$oneblock)-1);
    
    $lastblock = (int)(ceil($totalpage/$oneblock)-1);
    
    $startnum = (int)($thisblock*$oneblock+1);
    
    $endnum = (int)($thisblock*$oneblock+$oneblock+1);
    
    
    
    if($thispage!=1) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=1'><< </a>";
    
    if($thisblock!=0) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".($thisblock*$lastblock)."'>< </a>";
    
    for($i=$startnum; $i<$endnum; ++$i)
    
    {
        
        if($i>$totalpage) break;
        
        if($i==$thispage) $paging = $paging."<b>".$i."</b>";
        
        else $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$i."'>".$i."</a>";
        
    }
    
    if($thisblock!=$lastblock) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$endnum."'> ></a>";
    
    if($thispage!=$totalpage) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$totalpage."'> >></a>";
    
    
    
    $base->content = $base->content."<div id='paging'>".$paging."</div>";
    
}



$base->LayoutMain();

?>