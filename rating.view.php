<?php
/**
 * @class ratingView
 * @author Claude AI
 * @brief View class for rating module
 **/
class ratingView extends rating {
    /**
     * @brief Initialization
     **/
    function init() {
        // Set template path
        $this->setTemplatePath($this->module_path.'tpl');
    }
    
    /**
     * @brief Display rating widget
     **/
    function dispRatingWidget() {
        $document_srl = Context::get('document_srl');
        if(!$document_srl) return new BaseObject(-1, 'msg_invalid_request');
        
        // Get document rating info
        $oRatingModel = getModel('rating');
        $avg = $oRatingModel->getDocumentRatingAverage($document_srl);
        
        // Check if current user has already rated
        $already_rated = false;
        if(Context::get('is_logged')) {
            $member_srl = Context::get('logged_info')->member_srl;
            $existing = $oRatingModel->getRatingByMember($document_srl, $member_srl);
            if($existing->data) $already_rated = true;
        }
        
        Context::set('rating_avg', $avg->avg);
        Context::set('rating_count', $avg->count);
        Context::set('already_rated', $already_rated);
        
        $this->setTemplateFile('rating_widget');
        
        return new BaseObject();
    }
}