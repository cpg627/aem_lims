<?php
require_once "../include/layout.inc"; // 레이아웃을 include 함



$base = new Layout; // Layout class 객체를 생성

$base->link='../include/style.css'; // 임시 스타일 추가



$bn=$_GET['bn'];



if(($bn == 'notice' || $bn == 'programs') && $_SESSION['permit']!=3)

{
    
    header("Content-Type: text/html; charset=UTF-8");
    
    echo "<script>alert('접근할 수 없습니다.');history.back('/')</script>";
    
    exit;
    
}



//프로그램 부분

else if($bn=='programs')

{
    
    while (list($key, $value) = each($base->$pmenu))
    
    {
        
        if($key!='최신')
        
        {
            
            $pmenu = $pmenu."<option value='".$value."'>".$key."</option>";
            
        }
        
    }
    
    
    
    
    
    $base->content="
        
	<form action='./writing.php' method='post' enctype='multipart/form-data'>
        
		<div>
        
			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
        
			<input type='hidden' name='bn' value='".$bn."' />
			    
			<div>제목 <input type='text' name='title' size='80'/></div>
			    
			<div>카테고리
			    
			<select name='category'>
			    
				".$pmenu."
				    
			</select></div>
				    
			<div>지원 OS
				    
			<input type='checkbox' name='os1' value='WinXP'/>WinXP
				    
			<input type='checkbox' name='os2' value='WinVIsta'/>WinVista
				    
			<input type='checkbox' name='os3' value='Win7'/>Win7
				    
			<input type='checkbox' name='os4' value='Win8'/>Win8
				    
			<input type='checkbox' name='os5' value='Wine'/>Wine
				    
			<input type='checkbox' name='os6' value='Linux'/>Linux
				    
			<input type='checkbox' name='os7' value='Mac'/>Mac</div>
				    
			<div>한국어 지원 <input type='radio' name='kr' value='O'/>O<input type='radio' name='kr' value='X'/>X</div>
				    
			<div>라이센스
				    
				<select name='licence'>
				    
					<option value='1'>페이웨어 : 개인, 기업 유료</option>
				    
					<option value='2'>부분적 프리웨어 : 개인 무료, 기업 유료</option>
				    
					<option value='3'>프리웨어 : 개인, 기업 무료</option>
				    
					<option value='4'>쉐어웨어 : 일정기간 이후 유료</option>
				    
					<option value='5'>부분적 쉐어웨어 : 개인 메일 인증 시 무료, 기업 유료</option>
				    
				</select>
				    
			</div>
				    
			<div>링크 <input type='text' name='link' size='50'/></div>
				    
			<div><input type='file' name='userfile' id='userfile'/></div>
				    
			<div><textarea name='content' cols='90' rows='20'></textarea></div>
				    
			<input type='submit' value='글쓰기'/>
				    
		</div>
				    
	</form>
				    
	";
    
}



$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>