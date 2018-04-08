<?php

require_once "../include/layout.inc"; // 레이아웃을 include 함

require_once "../db/db.php";



$base = new Layout; // Layout class 객체를 생성

$base->link='../include/style.css'; // 임시 스타일 추가



$bn = $_POST['bn'];



if(($bn == 'notice' || $bn == 'programs') && $_SESSION['permit']!=3) // 전에 만들었던 권한 값이 3이 아니라면 접근 불가

{
    
    header("Content-Type: text/html; charset=UTF-8");
    
    echo "<script>alert('접근할 수 없습니다.');location.replace('/');</script>";
    
    exit;
    
} else if($bn=='notice') // 공지사항 부분

{
    
    $title = $_POST['title'];
    
    $content = $_POST['content'];
    
    $set = $_POST['set'];
    
    
    if(!(isset($title)&&isset($content)&&isset($set))) // title, content, set 변수가 존재하지 않으면 오류 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        echo "<script>alert('빈 칸이 존재합니다.');history.back();</script>";
        
        exit;
        
    }
    
    
    
    if ($_FILES['userfile']['error']>0) // 파일 업로드에 에러코드(1,2,3,4,6,7)가 0보다 크다면 관련 내용을 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        switch ($_FILES['userfile']['error'])
        
        {
            
            case 1:
                
                echo "<script>alert('파일의 크기가 최대 업로드 크기를 넘었습니다.');history.back()</script>";
                
                break;
                
            case 2:
                
                echo "<script>alert('파일의 크기가 최대 파일 크기를 넘었습니다.');history.back()</script>";
                
                break;
                
            case 3:
                
                echo "<script>alert('파일이 불완전하게 업로드 되었습니다.');history.back()</script>";
                
                break;
                
            case 4:
                
                echo "<script>alert('파일이 업로드 되지 않았습니다.');history.back()</script>";
                
                break;
                
            case 6:
                
                echo "<script>alert('파일을 업로드 할 수 없습니다.');history.back()</script>";
                
                break;
                
            case 7:
                
                echo "<script>alert('업로드에 실패하였습니다.');history.back()</script>";
                
                break;
                
        }
        
        exit;
        
    }
    
    
    if ($_FILES['userfile']['type'] !='image/jpeg' && $_FILES['userfile']['type'] !='image/png')
    
    // 이미지 확장자가 jpeg혹은 png가 아니라면 오류 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        echo "<script>alert('JPG 혹은 PNG 파일만 업로드 가능합니다.');history.back()</script>";
        
        exit;
        
    }
    
    
    
    $upfile = './images/'.$_FILES['userfile']['name']; // upfile 변수에 ./images/파일명으로 저장
    
    
    if (is_uploaded_file($_FILES['userfile']['tmp_name']))
    
    // 임시 저장 공간에 자료가 있다면 임시 공간에서 $upfile의 경로로 자료 이동을 해보고 실패하면 오류 출력
    {
        
        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile))
        
        {
            
            header("Content-Type: text/html; charset=UTF-8");
            
            echo "<script>alert('파일을 업로드 하지 못했습니다.');history.back()</script>";
            
            exit;
            
        }
        
    } else //자료가 없다면 오류 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        echo "<script>alert('파일 업로드 공격의 가능성이 있습니다. 파일명 : ".$_FILES['userfile']['name']."');history.back()</script>";
        
        exit;
        
    }
    
    
    
    $db = new DBC;
    
    $db->DBI();
    
    
    
    // query로 세션 값과 id, permit 부분이 멤버 테이블에 존재하는지 확인
    
    $db->query = "select id, pass, permit from member where id='".$_SESSION['id']."' and permit=".$_SESSION['permit'];
    
    $db->DBQ();
    
    $pass = $db->result->fetch_row();
    
    
    // query로 데이터를 삽입
    
    $db->query = "insert into ".$bn." values (null, '".$_SESSION['id']."', '".$pass[1]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$title."', '".$content."', ".$set.", '".$upfile."', 0)";
    
    
    
    $db->DBQ();
    
    
    if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력
    
    {
        
        echo "<script>alert('DB 전송에 실패했습니다.')</script>";
        
    } else
    
    {
        
        echo "<script>alert('글이 정상적으로 업로드 되었습니다.');location.replace('/".$bn."')</script>";
        
    }
    
    $db->DBO();
    
    
    
}



else if($bn=='programs') // 프로그램 부분

{
    
    
    
    // 프로그램 부분에 필요한 각각의 변수를 만들어줍니다.
    
    $category = $_POST['category'];
    
    $os = $_POST['os1']." ".$_POST['os2']." ".$_POST['os3']." ".$_POST['os4']." ".$_POST['os5']." ".$_POST['os6']." ".$_POST['os7'];
    
    $kr = $_POST['kr'];
    
    $link = $_POST['link'];
    
    $title = $_POST['title'];
    
    $content = $_POST['content'];
    
    $licence = $_POST['licence'];
    
    
    
    if(!(isset($category) && isset($os) && isset($kr) && isset($link) && isset($title) && isset($content) && isset($licence) && isset($_FILES['userfile']['name']))) // 비어있는 변수가 있다면 오류를 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        echo "<script>alert('빈 칸이 존재합니다.');history.back();</script>";
        
        exit;
        
    }
    
    
    
    if ($_FILES['userfile']['error']>0) // 파일 업로드에 에러코드(1,2,3,4,6,7)가 0보다 크다면 관련 내용을 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        switch ($_FILES['userfile']['error'])
        
        {
            
            case 1:
                
                echo "<script>alert('파일의 크기가 최대 업로드 크기를 넘었습니다.');history.back()</script>";
                
                break;
                
            case 2:
                
                echo "<script>alert('파일의 크기가 최대 파일 크기를 넘었습니다.');history.back()</script>";
                
                break;
                
            case 3:
                
                echo "<script>alert('파일이 불완전하게 업로드 되었습니다.');history.back()</script>";
                
                break;
                
            case 4:
                
                echo "<script>alert('파일이 업로드 되지 않았습니다.');history.back()</script>";
                
                break;
                
            case 6:
                
                echo "<script>alert('파일을 업로드 할 수 없습니다.');history.back()</script>";
                
                break;
                
            case 7:
                
                echo "<script>alert('업로드에 실패하였습니다.');history.back()</script>";
                
                break;
                
        }
        
        exit;
        
    }
    
    
    if ($_FILES['userfile']['type'] !='image/jpeg' && $_FILES['userfile']['type'] !='image/png')
    
    // 이미지 확장자가 jpeg혹은 png가 아니라면 오류 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        echo "<script>alert('JPG 혹은 PNG 파일만 업로드 가능합니다.');history.back()</script>";
        
        exit;
        
    }
    
    
    
    $upfile = './images/'.$_FILES['userfile']['name']; // upfile 변수에 ./images/파일명으로 저장
    
    
    if (is_uploaded_file($_FILES['userfile']['tmp_name']))
    
    {
        
        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile))
        
        // 임시 저장 공간에 자료가 있다면 임시 공간에서 $upfile의 경로로 자료 이동을 해보고 실패하면 오류 출력
        
        {
            
            header("Content-Type: text/html; charset=UTF-8");
            
            echo "<script>alert('파일을 업로드 하지 못했습니다.');history.back()</script>";
            
            exit;
            
        }
        
    } else //자료가 없다면 오류 출력
    
    {
        
        header("Content-Type: text/html; charset=UTF-8");
        
        echo "<script>alert('파일 업로드 공격의 가능성이 있습니다. 파일명 : ".$_FILES['userfile']['name']."');history.back()</script>";
        
        exit;
        
    }
    
    
    
    $db = new DBC;
    
    $db->DBI();
    
    // query로 세션 값과 id, permit 부분이 멤버 테이블에 존재하는지 확인
    
    $db->query = "select id, pass, permit from member where id='".$_SESSION['id']."' and permit=".$_SESSION['permit'];
    
    $db->DBQ();
    
    $pass = $db->result->fetch_row();
    
    
    // query로 데이터를 삽입
    
    $db->query = "insert into ".$bn." values(null, '".$_SESSION['id']."', '".$pass[1]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$category."', '".$title."', '".$content."', '".$link."', '".$os."', '".$kr."', '".$upfile."', ".$licence.")";
    
    $db->DBQ();
    
    
    if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력
    
    {
        
        echo "<script>alert('DB 전송에 실패했습니다.')</script>";
        
    } else
    
    {
        
        echo "<script>alert('글이 정상적으로 업로드 되었습니다.');location.replace('/".$bn."')</script>";
        
    }
    
    $db->DBO();
    
}



$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>