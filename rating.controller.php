<?php
/**
 * @class ratingController
 * @author Claude AI
 * @brief Controller class for rating module
 **/
class ratingController extends rating {
    /**
     * @brief Initialization
     **/
    function init() {
    }

    /**
     * @brief Submit rating
     **/
    function procRatingSubmit() {
        // Check if user is logged in
        if(!Context::get('is_logged')) return new BaseObject(-1, 'msg_not_logged');
        
        $args = new stdClass();
        $args->rating_srl = getNextSequence();
        $args->document_srl = Context::get('document_srl');
        $args->member_srl = Context::get('logged_info')->member_srl;
        $args->rating = Context::get('rating');
        $args->regdate = date('YmdHis');
        
        // Check if user already rated this document
        $oRatingModel = getModel('rating');
        $existing = $oRatingModel->getRatingByMember($args->document_srl, $args->member_srl);
        if($existing->data) return new BaseObject(-1, '이미 평가하셨습니다');
        
        // Insert rating
        $output = executeQuery('rating.insertRating', $args);
        if(!$output->toBool()) return $output;
        
        // Update document rating average
        $this->updateDocumentRating($args->document_srl);
        
        $this->setMessage('평가해 주셔서 감사합니다');
        
        // Redirect to original document
        $oDocumentModel = getModel('document');
        $oDocument = $oDocumentModel->getDocument($args->document_srl);
        $this->setRedirectUrl(getNotEncodedUrl('', 'document_srl', $args->document_srl));
        
        return new BaseObject();
    }
    
    /**
     * @brief Update document rating average
     **/
    function updateDocumentRating($document_srl) {
        $oRatingModel = getModel('rating');
        $avg = $oRatingModel->getDocumentRatingAverage($document_srl);
        
        // Update the document's extra_vars with rating information
        $oDocumentController = getController('document');
        $oDocumentController->updateExtraVar($document_srl, 'rating_avg', $avg->avg);
        $oDocumentController->updateExtraVar($document_srl, 'rating_count', $avg->count);
        
        return new BaseObject();
    }
}