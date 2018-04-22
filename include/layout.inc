<?php

// 세션을 시작합니다.

// 이후에 사용 할 로그인 용.

session_start();



// class를 이용한 객체 지향 방식

class Layout

{
    
    public $title="SBR system"; // 웹 페이지 제목
    
    public $menu = array('Intro'=>'intro', 'SBR_Lims'=>'SBR_Lims', 'Lab_Manage'=>'lab manage', 'Choi-Q_Potal'=>'Choi-Q_Potal', 'e-Spec'=>'e-Spec');
    
//    public $SBR_menu = array('전체'=>'?tn=all', '압축'=>'?tn=press');
    public $SBR_menu = array('분석의뢰'=>'Request', '분석결과 조회'=>'Result');
    
    public $Lab_menu = array('Retain샘플 현황'=>'Retain_Sample', 'PFA 샘플병 관리'=>'PFA_bottle', '검사원 자격인증'=>'Membership');
    
    public $link; // CSS 링크 태그
    
    public $style; // 스타일 적용
    
    public $content; // 메인 컨텐츠
    
    public $board; //게시판 이름 지정
    
    public $sub; // 서브 메뉴용 변수
    
    public $login; // 로그인이나 로그아웃을 출력
   
    
    // 레이아웃을 출력
    
    public function LayoutMain()
    
    {
        
        echo $this->ThisBoard(); // 현재 게시판의 이름을 확인
        
        echo "<!DOCTYPE html>\n<html lang='ko'>";
        
        echo "<head>\n<meta charset='utf-8'/>";
        
        echo "<title>".$this->title."</title>";
        
        echo $this->LayoutStyle(); // 스타일을 레이아웃에 추가.
        
        echo "</head>\n<body>\n<div id='container'>";
        
        echo	$this->LayoutHeader(); // 헤더 부분을 레이아웃에 추가
        
        echo	$this->LayoutContent(); // 컨텐츠 부분을 레이아웃에 추가
        
        echo	$this->LayoutSide(); // 사이드 부분을 레이아웃에 추가
        
        echo	$this->LayoutFooter(); // 푸터 부분을 레이아웃에 추가
        
        echo "</div></body>\n</html>";
        
    }
    
    
    
    // 현재 게시판의 이름을 확인
    
    public function ThisBoard()
    
    {
        
        $this->board = explode('/', $_SERVER['PHP_SELF']);
        
    }
    
    
    
    // 스타일을 추가
    
    public function LayoutStyle()
    
    {
        
        echo "<link rel='stylesheet' type='text/css' href='".$this->link."'/> ";
        
        echo "<style>".$this->style."</style>";
        
    }
    
    
    
    // 헤더 부분 추가
    
    public function LayoutHeader()
    
    {
        
        $this->LayoutLogin();
        
        echo "<header>
            
			<div id='logo'><h1><a href='/aem_lims/programs'>SBR system</a></h1></div>
            
				<div id='navset'>
            
					<nav id='menu'>
            
						";
        
        $this->LayoutMenu($this->menu, 0); // $menu 배열을 이용해서 메뉴 부분을 호출
        
        echo "		</nav>
            
					<nav id='login'>".$this->login."</nav>
					    
				</div>
					    
			<div class='ad_1'> 
					    
				<img src='../pic/Main_background.jpg'>
					    
			</div>
					    
		</header>";
        
    }
    
    public function LayoutMenu($menu, $side) // 배열과 <li> 을 이용해서 메뉴 부분을 호출
    
    {
        
        while (list($key, $value) = each($menu))
        
        {
            
            $this->ThisMenu($key, $value, $side);
            
        }
        
    }
    
    
    
    public function ThisMenu($key, $value ,$side) //받아온 값으로 메뉴를 출력함
    
    {
        
        if($side=='1')
        
        {
            
            if(strpos($_SERVER['REQUEST_URI'], $value)==false)
            
            {
                
                $thismenu = $thismenu."<li><a href='./".$value."'>".$key."</a></li>";
                
            } else
            
            {
                
                $thismenu = $thismenu."<li><b style='border-bottom:4px solid #90bbff;'>".$key."</b></li>";
                
            }
            
        } else
        
        {
            
            if(strpos($_SERVER['PHP_SELF'], $value)==false)
            
            {
                
                $thismenu = $thismenu."<li><a href='./".$value."'>".$key."</a></li>";
                
            } else
            
            {
                
                $thismenu = $thismenu."<li><b style='border-bottom:4px solid #90bbff;'>".$key."</b></li>";
                
            }
            
        }
        
        echo $thismenu;
        
    }
    
    
    
    public function LayoutLogin()
    
    {
        
        if($_SESSION['id']=="")
        
        {
            if(strpos($_SERVER['PHP_SELF'], "login.php")) //문자열이 포함되어 있는지 확인 하는 함수
            
            {
                
                $this->login="<b style='border-bottom:3px solid #90bbff;'>Login</b>";
                
            } else
            
            {
                
                $this->login="<a href='../login/login.php'>Login</a>";
                
            }
            
        } else
        
        {
            
            $this->login="<a href='../login/logout.php'>Logout</a>";
            
        }
        
    }
    
    
    
    // 내용을 추가
    
    public function LayoutContent()
    
    {
        
        echo "<section><article>".$this->content."</article>";
        
    }
    
    
    
    // 사이드바 추가
    
    public function SideMenu()
    
    {
        
        $this->board=explode('/', $_SERVER['PHP_SELF']);
        //echo $this->board[2]; //프로젝트에 aem_lims라는 이름을 한번더 사용 했으므로 board[1]는 aem_lims, board[2]는 program이 표시 된다. 큰 카테고리를 지정하여 사이드 메뉴를 표기
        
        switch($this->board[2])
        
        {
            
            //'Intro'=>'intro', 'SBR_Lims'=>'SBR_Lims', 'Lab Manage'=>'lab_manage', 'Choi-Q_Potal'=>'Choi-Q_Potal', 'e-Spec'=>'e-Spec'
            case intro :
                
                echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>Introduction</a></h3>";
             
                if($_SESSION['permit']==3)
                
                {
                    
                    echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
                    
                }
                
                break;
                
            case SBR_Lims :
                
                echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>SBR_Lims</a></h3>";
                
                $this->LayoutMenu($this->SBR_menu, 1);
                
                if($_SESSION['permit']==3)
                
                {
                    
                    echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
                    
                }
                
                break;
                
            case lab_manage :
                
                echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>SBR_Lims</a></h3>";
                
                $this->LayoutMenu($this->SBR_menu, 1);
                
                if($_SESSION['permit']==3)
                
                {
                    
                    echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
                    
                }
                
                break;
                
            case Choi-Q_Potal :
                
                echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>SBR_Lims</a></h3>";
                
                $this->LayoutMenu($this->SBR_menu, 1);
                
                if($_SESSION['permit']==3)
                
                {
                    
                    echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
                    
                }
                
                break;
                
                
            case e-Spec :
                
                echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>게시판</a></h3>";
                
                $this->LayoutMenu($this->Lab_menu, 1);
                
                break;
                
            default :
               
                if(isset($_SESSION['id']) && isset($_SESSION['permit']))
                
                {
                    
                    echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><b	style='padding:20px;'>";
                    
                    switch($_SESSION['permit'])
                    
                    {
                        
                        case 1 : echo "일반회원";
                        
                        break;
                        
                        case 2 : echo "특별회원";
                        
                        break;
                        
                        case 3 : echo "관리자";
                        
                        break;
                        
                    }
                    
                    echo "</b><b style='padding:20px;'>".$_SESSION['id']."</b></div>";
                    
                }
                
        }
        
    }
    
    
    
    public function LayoutSide()
    
    {
        
        echo "<aside>";
        
        $this->SideMenu();
        
        echo "</aside></section>";
        
    }
    
    
    
    // 푸터 부분 추가
    
    public function LayoutFooter()
    
    {
        
        echo "<footer class = 'basf_2'>
                <div> 
                    <img src='../pic/logo_basf.svg' width=15%>
                
                    
                </div> 
                <center> Copyright © p-production. All rights reserved. SBR </center>
               </footer>";
        
    }
    
}

?>