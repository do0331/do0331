<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>


<hr class="padding">
<section id="bo_w">
	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<?php
	$option = '';
	$option_hidden = '';
	$sec='';
	if ($is_notice || $is_html || $is_secret || $is_mail) {
		$option = '';
		if ($is_notice) {
			$option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
		}

		if ($is_html) {
			if ($is_dhtml_editor) {
				$option_hidden .= '<input type="hidden" value="html1" name="html">';
			} else {
				$option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
			}
		}


		if ($is_mail) {
			$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
		}

		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
				if($secret_checked)$sec_select="selected";
				$sec .='<option value="secret" '.$sec_select.'>비밀글</option>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}
	}

	echo $option_hidden; 
		if($write['wr_secret']=='1') $mem_select="selected";
		if($write['wr_protect']!='') $pro_select="selected";
		if($is_member) {$sec .='<option value="protect" '.$pro_select.'>보호글</option>';
		$sec .='<option value="member" '.$mem_select.'>멤버공개</option>';}
	?>

	<div class="board-write theme-box">
	<?php if ($is_category) { ?>
	<dl>
		<dt>CATEGORY</dt>
		<dd><nav id="write_category">
			<select name="ca_name" id="ca_name" required class="required" >
				<option value="">선택하세요</option>
				<?php echo $category_option ?>
			</select> 
		</nav>
		</dd>
	</dl>
	<?}?>
	<dl>
		<dt>OPTION</dt>
		<dd>
		<?if($is_secret!=2||$is_admin){?>
		<select name="set_secret" id="set_secret">
			<option value="">전체공개</option>
			<?=$sec?>
		</select>
		<?}?>
		<?php echo $option ?></dd>
	</dl>
	<dl id="set_protect" style="display:<?=$w=='u' && $pro_select ? 'block':'none'?>;">
		<dt><label for="wr_protect">보호글 암호</label></dt>
		<dd><input type="text" name="wr_protect" id="wr_protect" value="<?=$write['wr_protect']?>" maxlength="20"></dd>
	</dl>
	<dl>
		<dt>페어명</dt>
		<dd><input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required full" size="50" maxlength="255"></dd>
	</dl>
	<dl>
		<dt>페어설명</dt>
		<dd>
		<input type="text" name="wr_content" value="<?php echo $write['wr_content'] ?>" id="wr_content" class="frm_input required full" size="50" maxlength="255">
	</dd>
	</dl>
	<dl>
		<dt>이미지</dt>
		<dd>
		
		<div class="files">  
		<?=help("※ 이미지 삭제는 외부링크란을 공란으로 만든 후 이미지 삭제 버튼까지 함께 눌러서 사용해주세요.")?>
				<div class="sub"><span class="sub_tit">메인이미지</span>
				<input type="file" name="bf_file[0]" title="메인이미지 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input"> 
				<span class="sub_tit">외부링크</span><input type="text" name="wr_1" value="<?=$w=='u' ? $write['wr_1']: ""?>"> 
				<?if($w=='u' && $write['wr_1']){?>
				<a href="<?=$write['wr_1']?>" class="ui-btn" target="_blank">메인이미지 확인</a>
				<input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="wr_1"> <label for="bf_file_del0"> 등록된 이미지 삭제</label><?}?>
				</div> 
				<?if($board['bo_upload_count']>1){?><div class="sub"><span class="sub_tit">왼쪽이미지</span>
				<input type="file" name="bf_file[1]" title="왼쪽이미지 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
				<span class="sub_tit">외부링크</span><input type="text" name="wr_2" value="<?=$w=='u' ? $write['wr_2']: ""?>" class="frm_input" size="10"> 
				<?if($w=='u' && $write['wr_2']){?>
				<a href="<?=$write['wr_2']?>" class="ui-btn" target="_blank">왼쪽이미지 확인</a>
				<input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="wr_2"> <label for="bf_file_del1"> 등록된 이미지 삭제</label><?}?>
				<?}?>

				<?if($board['bo_upload_count']>2){?><div class="sub"><span class="sub_tit">오른쪽이미지</span>
				<input type="file" name="bf_file[2]" title="오른쪽이미지 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
				<span class="sub_tit">외부링크</span><input type="text" name="wr_3" value="<?=$w=='u' ? $write['wr_3']: ""?>">
				<?if($w=='u' && $write['wr_3']){?>
				<a href="<?=$write['wr_3']?>" class="ui-btn" target="_blank">오른쪽이미지 확인</a>
				<input type="checkbox" id="bf_file_del2" name="bf_file_del[2]" value="wr_3"> <label for="bf_file_del2"> 등록된 이미지 삭제</label><?}?>
				</div>  
				<?}?>

				<?if($board['bo_upload_count']>3){?><div class="sub"><span class="sub_tit">배경</span>
				<input type="file" name="bf_file[3]" title="배경 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
				<span class="sub_tit">외부링크</span><input type="text" name="wr_4" value="<?=$w=='u' ? $write['wr_4']: ""?>">
				<?if($w=='u' && $write['wr_4']){?>
				<a href="<?=$write['wr_4']?>" class="ui-btn" target="_blank">배경 확인</a>
				<input type="checkbox" id="bf_file_del3" name="bf_file_del[3]" value="wr_4"> <label for="bf_file_del3"> 등록된 이미지 삭제</label><?}?>
				</div>  
				<?}?>

				<?if($board['bo_upload_count']>4){?><div class="sub"><span class="sub_tit">SD(L)</span>
				<input type="file" name="bf_file[4]" title="SD(L) 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
				<span class="sub_tit">외부링크</span><input type="text" name="wr_5" value="<?=$w=='u' ? $write['wr_5']: ""?>">
				<?if($w=='u' && $write['wr_5']){?>
				<a href="<?=$write['wr_5']?>" class="ui-btn" target="_blank">SD(L) 확인</a>
				<input type="checkbox" id="bf_file_del4" name="bf_file_del[4]" value="wr_5"> <label for="bf_file_del4"> 등록된 이미지 삭제</label><?}?>
				</div>  
				<?}?>

				<?if($board['bo_upload_count']>5){?><div class="sub"><span class="sub_tit">SD(R)</span>
				<input type="file" name="bf_file[5]" title="SD(R) 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
				<span class="sub_tit">외부링크</span><input type="text" name="wr_6" value="<?=$w=='u' ? $write['wr_6']: ""?>">
				<?if($w=='u' && $write['wr_6']){?>
				<a href="<?=$write['wr_6']?>" class="ui-btn" target="_blank">SD(R) 확인</a>
				<input type="checkbox" id="bf_file_del5" name="bf_file_del[5]" value="wr_6"> <label for="bf_file_del5"> 등록된 이미지 삭제</label><?}?>
				</div>  
				<?}?>
	</dd>

	</dl>
	<dl>
		<dt>출처</dt>
		<dd>
		<?=help("※ 출처 이름만 |를 구분선으로 사용해 나열해 적어주세요. ex) 홍길동님|허준님")?>
		<input type="text" name="wr_facebook_user" value="<?php echo $write['wr_facebook_user'] ?>" id="wr_facebook_user" class="frm_input full" size="50" maxlength="255">
	</dd>
	</dl>
	<dl>
		<dt>이름(L)</dt>
		<dd>
		<?=help("※ 한글이름|원문이름 순으로 작성합니다.")?>
		<input type="text" name="wr_twitter_user" value="<?php echo $write['wr_twitter_user'] ?>" id="wr_twitter_user" class="frm_input full" size="50" maxlength="255">
	</dd>
	</dl>
	<dl>
		<dt>세부(L)</dt>
		<dd>
		<input type="text" name="wr_7" value="<?php echo $write['wr_7'] ?>" id="wr_7" class="frm_input full" size="50" maxlength="255">
	</dd>
	</dl>
	<dl>
		<dt>이름(R)</dt>
		<dd>
		<?=help("※ 한글이름|원문이름 순으로 작성합니다.")?>
		<input type="text" name="wr_8" value="<?php echo $write['wr_8'] ?>" id="wr_8" class="frm_input full" size="50" maxlength="255">
	</dd>
	</dl>
	<dl>
		<dt>세부(R)</dt>
		<dd>
		<input type="text" name="wr_9" value="<?php echo $write['wr_9'] ?>" id="wr_9" class="frm_input full" size="50" maxlength="255">
	</dd>
	</dl>
	<dl>
		<dt>테마컬러</dt>
		<dd>
		<?=help("※ 두 컬러를 #포함해서 |를 구분선으로 사용해 적어주세요. ex) #ffffff|#000000")?>
		<input type="text" name="wr_10" value="<?php echo $write['wr_10'] ?>" id="wr_10" class="frm_input full" size="50" maxlength="255">
	</dd>
	</dl>
		<? if($board['bo_1']) { ?>
		<div class="write-notice">
			<?=$board['bo_1']?>
		</div>
		<? } ?>


	<?if(!$is_member){?>
	<dl>
		<dt></dt>
		<dd class="txt-right">
    <?php if ($is_name) { ?>
        <label for="wr_name">NAME<strong class="sound_only">필수</strong></label>
        <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" >
    <?php } ?>

    <?php if ($is_password) { ?>
		&nbsp;&nbsp;
        <label for="wr_password">PASSWORD<strong class="sound_only">필수</strong></label>
        <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" >
    <?php } ?>
	</dd>
	</dl>
	<?}?>
		 
	</div>

	<hr class="padding" />
	<div class="btn_confirm txt-center">
		<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit ui-btn point">
		<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel ui-btn">취소</a>
	</div>
	</form>

	<script>
	<?php if($write_min || $write_max) { ?>
	// 글자수 제한
	var char_min = parseInt(<?php echo $write_min; ?>); // 최소
	var char_max = parseInt(<?php echo $write_max; ?>); // 최대
	check_byte("wr_content", "char_count");

	$(function() {
		$("#wr_content").on("keyup", function() {
			check_byte("wr_content", "char_count");
		});
	});

	<?php } ?>
	function html_auto_br(obj)
	{
		if (obj.checked) {
			result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
			if (result)
				obj.value = "html2";
			else
				obj.value = "html1";
		}
		else
			obj.value = "";
	}

	function fwrite_submit(f)
	{
		<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": f.wr_subject.value,
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		if (subject) {
			alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
			f.wr_subject.focus();
			return false;
		}

		if (content) {
			alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
			if (typeof(ed_wr_content) != "undefined")
				ed_wr_content.returnFalse();
			else
				f.wr_content.focus();
			return false;
		}

		if (document.getElementById("char_count")) {
			if (char_min > 0 || char_max > 0) {
				var cnt = parseInt(check_byte("wr_content", "char_count"));
				if (char_min > 0 && char_min > cnt) {
					alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
					return false;
				}
				else if (char_max > 0 && char_max < cnt) {
					alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
					return false;
				}
			}
		}
 

		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	}	
	$('#set_secret').on('change', function() {
		var selection = $(this).val();
		if(selection=='protect') $('#set_protect').css('display','block');
		else {$('#set_protect').css('display','none'); $('#wr_protect').val('');}
	});  
	</script>
</section>
<!-- } 게시물 작성/수정 끝 -->