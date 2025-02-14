<?php
if(!defined('__XE__')) exit();

/**
 * @file rating.addon.php
 * @author 80san
 * @brief 게시글 평점 애드온
 */

// 글 보기 페이지에서만 실행
if(Context::get('act') == 'dispBoardContent') {
	// CSS 추가
	Context::addCSSFile('./addons/rating/tpl/rating.css');
	// JS 추가
	Context::addJsFile('./addons/rating/tpl/rating.js');
	
	// 현재 문서 번호와 로그인 회원 정보 가져오기
	$document_srl = Context::get('document_srl');
	$logged_info = Context::get('logged_info');
	
	try {
		// 이미 평가했는지 확인
		$args = new stdClass();
		$args->document_srl = $document_srl;
		$args->member_srl = $logged_info->member_srl;
		$output = executeQuery('addons.rating.getRating', $args);
		$rating = $output->data ? (float)$output->data->rating : 0;
		
		// 평균 평점 가져오기 부분을 수정
		$args = new stdClass();
		$args->document_srl = $document_srl;
		$output = executeQuery('addons.rating.getAverageRating', $args);
		$avg_rating = $output->data ? (float)$output->data->avg_rating : 0;
		$rating_count = $output->data ? (int)$output->data->rating_count : 0;

		// 템플릿에 변수 추가
		Context::set('user_rating', $rating);
		Context::set('avg_rating', $avg_rating);
		Context::set('rating_count', $rating_count);
		
		// 템플릿 경로 설정 및 컴파일
		// $addon_path = str_replace('rating.addon.php', '', str_replace('\\', '/', __FILE__));
		// $template_path = sprintf('%stpl/', $addon_path);
		// $oTemplate = &TemplateHandler::getInstance();
		// $rating_form = $oTemplate->compile($template_path, 'rating.html');
		
	} catch (Exception $e) {
		// 에러 발생 시 조용히 처리
		Context::set('user_rating', 0);
		Context::set('avg_rating', 0);
	}
}

// AJAX 요청 처리
if(Context::get('act') == 'procRatingInsert') {
	$document_srl = Context::get('document_srl');
	$rating = Context::get('rating');
	$logged_info = Context::get('logged_info');
	
	if(!$logged_info) return new BaseObject(-1, 'msg_not_logged');
	
	try {
		$args = new stdClass();
		$args->document_srl = $document_srl;
		$args->member_srl = $logged_info->member_srl;
		$args->rating = $rating;
		
		// 이미 평가했다면 업데이트
		$output = executeQuery('addons.rating.getRating', $args);
		if($output->data) {
			$output = executeQuery('addons.rating.updateRating', $args);
		} else {
			$output = executeQuery('addons.rating.insertRating', $args);
		}
		
		if(!$output->toBool()) return $output;
		
		// 평균 평점 다시 계산
		$args = new stdClass();
		$args->document_srl = $document_srl;
		$output = executeQuery('addons.rating.getAverageRating', $args);
		
		$returnObj = new BaseObject();
		$returnObj->add('avg_rating', $output->data->avg_rating);
		return $returnObj;
		
	} catch (Exception $e) {
		return new BaseObject(-1, '평가 처리 중 오류가 발생했습니다.');
	}
}