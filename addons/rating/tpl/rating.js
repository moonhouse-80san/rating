jQuery(function($) {
	$('.user-rating .star').click(function(e) {
		e.preventDefault();
		
		var rating = $(this).data('value');
		var document_srl = current_url.getQuery('document_srl');
		
		var params = {
			document_srl: document_srl,
			rating: rating
		};
		
		exec_json(
			'rating.procRatingInsert',
			params,
			function(data) {
				alert(data.message || '평가가 완료되었습니다.');
				if(!data.error) {
					location.reload();
				}
			}
		);
	});
});