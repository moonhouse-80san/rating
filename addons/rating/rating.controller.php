<?php
class ratingController extends Controller
{
	function init() {
	}

	function procRatingInsert()
	{
		$document_srl = Context::get('document_srl');
		$rating = Context::get('rating');
		$logged_info = Context::get('logged_info');

		// 로그인 체크
		if(!$logged_info) return new BaseObject(-1, 'msg_not_logged');

		// 이미 평가했는지 확인
		$args = new stdClass();
		$args->document_srl = $document_srl;
		$args->member_srl = $logged_info->member_srl;
		$output = executeQuery('addons.rating.getRating', $args);
		
		if($output->data) {
			// 이미 평가한 경우
			return new BaseObject(-1, '이미 평가하셨습니다.');
		}

		// 평가 입력
		$args->rating = $rating;
		$output = executeQuery('addons.rating.insertRating', $args);
		
		if(!$output->toBool()) return $output;

		// 평균 평점 계산
		$args = new stdClass();
		$args->document_srl = $document_srl;
		$output = executeQuery('addons.rating.getAverageRating', $args);

		$this->setMessage('평가가 완료되었습니다.');
		$this->add('avg_rating', $output->data->avg_rating);
		
		return new BaseObject();
	}
}