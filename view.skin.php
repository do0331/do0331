<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// CSS 설정 가져오기
$css_sql = sql_query("select * from {$g5['css_table']}");
$css = array();
for($i=0; $cs = sql_fetch_array($css_sql); $i++) {
	$css[$cs['cs_name']][0] = $cs['cs_value'];
	$css[$cs['cs_name']][1] = $cs['cs_etc_1'];
	$css[$cs['cs_name']][2] = $cs['cs_etc_2'];
	$css[$cs['cs_name']][3] = $cs['cs_etc_3'];
	$css[$cs['cs_name']][4] = $cs['cs_etc_4'];
	$css[$cs['cs_name']][5] = $cs['cs_etc_5'];
	$css[$cs['cs_name']][6] = $cs['cs_etc_6'];
	$css[$cs['cs_name']][7] = $cs['cs_etc_7'];
	$css[$cs['cs_name']][8] = $cs['cs_etc_8'];
	$css[$cs['cs_name']][9] = $cs['cs_etc_9'];
	$css[$cs['cs_name']][10] = $cs['cs_etc_10'];
}


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
$p_url="";
if ($view['wr_protect']!=''){
	if( get_session("ss_secret_{$bo_table}_{$view['wr_num']}") ||  $view['mb_id'] && $view['mb_id']==$member['mb_id'] || $is_admin )
		$is_viewer = true;
	else {
	$is_viewer = false; 
	$p_url="./password.php?w=p&amp;bo_table=".$bo_table."&amp;wr_id=".$view['wr_id'].$qstr;
	}
}else if($view['wr_secret'] == '1') {
	if($board['bo_read_level'] < $member['mb_level'] && $is_member)
		$is_viewer = true; 
	else {
	$is_viewer = false; 
	$p_url="./login.php";
	}
}
if(!$is_viewer && $p_url!=''){
	if($p_url=="./login.php") alert("멤버공개 글입니다. 로그인 후 이용해주세요.",$p_url);
	else goto_url($p_url);
}

$view['wr_8']=explode('|',$view['wr_8']);
$view['wr_10']=explode('|',$view['wr_10']);
$view['wr_twitter_user']=explode('|',$view['wr_twitter_user']);
$source=explode('|',$view['wr_facebook_user'])
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hachi+Maru+Pop&display=swap" rel="stylesheet">

<script src="<? echo G5_JS_URL; ?>/viewimageresize.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

<style>

#header {display:none; z-index: 5;}

@media all and (max-width: 1000px) {
	#header {display:block;}
}

<? if($css['menu_pos'][0] == 'left') { ?>

#body{margin-left:0;}
#footer {margin-left:0;}
<?}?>
	
#body .fix-layout {max-width: 100% !important;}

<?if($view['wr_4']){?>
@media all and (min-width: 1001px) { 
	html			{
		background-image: url('<?=$view['wr_4']?>'),url('<?=$css['background'][0]?>');
		background-size: cover;
		background-attachment: fixed;
	}
}

@media all and (max-width: 1000px) {
	html			{
		background-image: url('<?=$view['wr_4']?>'),url('<?=$css['m_background'][0]?>');
		background-size: cover;
		background-attachment: fixed;
	}

}
<?}?>
<?if($view['wr_10'][0]){?>
.subject span {
	background: linear-gradient(to right, <?=$view['wr_10'][0]?>, <?=$view['wr_10'][1]?>);
    color: transparent;
    -webkit-background-clip: text;
	text-shadow:none;
	filter: drop-shadow(0 0 4px rgba(0,0,0,0.5));
}
<?}?>

</style>

	<!-- 링크 버튼 시작 { -->
	<div id="bo_v_bot">
		<div class="menu_on only-pc">ON</div>
		<div class="bottom_menu">
		<?
		ob_start();
		 ?>
		<? if ($prev_href || $next_href) { ?>
		<div class="bo_v_nb">
			<? if ($prev_href) { ?><a href="<? echo $prev_href ?>" class="ui-btn">이전글</a><? } ?>
			<? if ($next_href) { ?><a href="<? echo $next_href ?>" class="ui-btn">다음글</a><? } ?>
		</div>
		<? } ?>

		<div class="bo_v_com">
			<? if ($update_href) { ?><a href="<? echo $update_href ?>" class="ui-btn">수정</a><? } ?>
			<? if ($search_href) { ?><a href="<? echo $search_href ?>" class="ui-btn">검색</a><? } ?>
			<a href="<? echo $list_href ?>" class="ui-btn">목록</a>
			<? if ($write_href) { ?><a href="<? echo $write_href ?>" class="ui-btn point">글쓰기</a><? } ?>
		</div>
		<?
		$link_buttons = ob_get_contents();
		ob_end_flush();
		 ?>
		 </div>
	</div>
	<!-- } 링크 버튼 끝 -->

	<div class="grad_black"></div>
	<div class="content_wrap animated fadeIn slow">
		<div class="fair_title">
			<div class="subject"><span><?=$view['wr_subject']?></span></div>
			<div class="fair_detail"><?=$view['wr_content']?></div>
		</div>

		<div class="image">
			<?if($view['wr_1']){?>
			<div class="main_image main" style="background-image:url('<?=$view['wr_1']?>')"><img src="<?=$view['wr_1']?>"></div>
			<?}?>
			<?if($view['wr_2']){?>
			<div class="main_image left" style="background-image:url('<?=$view['wr_2']?>')"><img src="<?=$view['wr_2']?>"></div>
			<?}?>
			<?if($view['wr_3']){?>
			<div class="main_image right" style="background-image:url('<?=$view['wr_3']?>')"><img src="<?=$view['wr_3']?>"></div>
			<?}?>
		</div>
		
		<div class="modal">
			<div class="modalBox">
			</div>
		</div>

		<span class="source">
		<? for($j=0; $j < count($source); $j++) {
								$result = $source[$j];
								if(!$result) continue;

								echo "ⓒ$result ";
		
		}?>

		</span>


		<div class="bottom_content">
			<div class="character_detail left">
				<div class="sd_image"><img src="<?=$view['wr_5']?>" class="sd"></div>
				<div class="cha_name" style="color: <?=$view['wr_10'][0]?>;"><?=$view['wr_twitter_user'][1]?></div>
				<div class="kr_name"><?=$view['wr_twitter_user'][0]?></div>
				<?if($view['wr_7']){?>
				<div class="cha_detail" style="background:<?=$view['wr_10'][0]?>;"><?=$view['wr_7']?></div>
				<?}?>
			</div>

			<div class="character_detail right">
				<div class="sd_image"><img src="<?=$view['wr_6']?>" class="sd"></div>
				<div class="cha_name" style="color: <?=$view['wr_10'][1]?>;"><?=$view['wr_8'][1]?></div>
				<div class="kr_name"><?=$view['wr_8'][0]?></div>
				<?if($view['wr_9']){?>
				<div class="cha_detail" style="background:<?=$view['wr_10'][1]?>;"><?=$view['wr_9']?></div>
				<?}?>
			</div>
		</div>
		<?if($view['wr_10'][0]){?>
		<div class="color">
			<span>THEME</span>
			<div class="color_box left" style="background:<?=$view['wr_10'][0]?>;"></div>
			<div class="color_box right" style="background:<?=$view['wr_10'][1]?>;"></div>
		</div>
		<?}?>
	</div>
	<div class="grad"></div>

	<!--- 디자인 카피라이트 삭제금지--->
	<div class="bearcommi">SkinD. <a href="http://twitter.com/bearcommi" target="_blank">@BEARCOMMI</a></div>
	<!--/// -->
	
<script>

    $(".menu_on").click(function(){
        $("#header").fadeToggle();
		$(".bottom_menu").fadeToggle();
		$(this).text($(this).text() == 'ON' ? 'OFF' : 'ON');
    });

	$(function(){
//     이미지 클릭시 해당 이미지 모달
    $(".main_image").click(function(){
        let img = new Image();
		img.src = $(this).children("img").attr("src")
        $('.modalBox').html(img);
        $(".modal").fadeIn();
    });
	$(".sd").click(function(){
        let img = new Image();
        img.src = $(this).attr("src")
        $('.modalBox').html(img);
        $(".modal").fadeIn();
    });
// 모달 클릭할때 이미지 닫음
    $(".modal").click(function (e) {
    $(".modal").fadeToggle();
  });
});

function doImgPop(img){ 
 img1= new Image(); 
 img1.src=(img); 
 imgControll(img); 
} 
  
function imgControll(img){ 
 if((img1.width!=0)&&(img1.height!=0)){ 
    viewImage(img); 
  } 
  else{ 
     controller="imgControll('"+img+"')"; 
     intervalID=setTimeout(controller,20); 
  } 
}

function viewImage(img){ 
 W=img1.width; 
 H=img1.height; 
 O="width="+W+",height="+H+",scrollbars=yes"; 
 imgWin=window.open("","",O); 
 imgWin.document.write("<html><head><title>:*:*:*: 이미지상세보기 :*:*:*:*:*:*:</title></head>");
 imgWin.document.write("<body topmargin=0 leftmargin=0>");
 imgWin.document.write("<img src="+img+" onclick='self.close()' style='cursor:pointer;' title ='클릭하시면 창이 닫힙니다.'>");
 imgWin.document.close();
}

function board_move(href)
{
	window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});

	// 추천, 비추천
	$("#good_button, #nogood_button").click(function() {
		var $tx;
		if(this.id == "good_button")
			$tx = $("#bo_v_act_good");
		else
			$tx = $("#bo_v_act_nogood");

		excute_good(this.href, $(this), $tx);
		return false;
	});

	// 이미지 리사이즈
	$("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
	$.post(
		href,
		{ js: "on" },
		function(data) {
			if(data.error) {
				alert(data.error);
				return false;
			}

			if(data.count) {
				$el.find("strong").text(number_format(String(data.count)));
				if($tx.attr("id").search("nogood") > -1) {
					$tx.text("이 글을 비추천하셨습니다.");
					$tx.fadeIn(200).delay(2500).fadeOut(200);
				} else {
					$tx.text("이 글을 추천하셨습니다.");
					$tx.fadeIn(200).delay(2500).fadeOut(200);
				}
			}
		}, "json"
	);
}
</script>
<!-- } 게시글 읽기 끝 -->