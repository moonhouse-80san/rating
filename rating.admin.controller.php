<?php
/**
 * @class ratingAdminController
 * @author Claude AI
 * @brief Admin controller class for rating module
 **/
class ratingAdminController extends rating {
    /**
     * @brief Initialization
     **/
    function init() {
    }
    
    /**
     * @brief Save module config
     **/
    function procRatingAdminInsertConfig() {
        $args = new stdClass();
        $args->display_stars = Context::get('display_stars') ? 'Y' : 'N';
        $args->allow_guests = Context::get('allow_guests') ? 'Y' : 'N';
        $args->max_rating = Context::get('max_rating');
        $args->target_modules = Context::get('target_modules');
        
        // Create module controller instance
        $oModuleController = getController('module');
        $output = $oModuleController->insertModuleConfig('rating', $args);
        
        if(!$output->toBool()) return $output;
        
        $this->setMessage('성공적으로 저장했습니다.');
        $this->setRedirectUrl(getNotEncodedUrl('', 'module', 'admin', 'act', 'dispRatingAdminIndex'));
        
        return new BaseObject();
    }
    
    /**
     * @brief Delete rating
     **/
    function procRatingAdminDeleteRating() {
        $rating_srl = Context::get('rating_srl');
        if(!$rating_srl) return new BaseObject(-1, '잘못된 요청입니다.');
        
        $args = new stdClass();
        $args->rating_srl = $rating_srl;
        $output = executeQuery('rating.deleteRating', $args);
        
        if(!$output->toBool()) return $output;
        
        $this->setMessage('성공적으로 삭제했습니다.');
        $this->setRedirectUrl(getNotEncodedUrl('', 'module', 'admin', 'act', 'dispRatingAdminList'));
        
        return new BaseObject();
    }
}