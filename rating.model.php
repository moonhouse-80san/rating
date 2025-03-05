<?php
/**
 * @class ratingModel
 * @author Claude AI
 * @brief Model class for rating module
 **/
class ratingModel extends rating {
    /**
     * @brief Initialization
     **/
    function init() {
    }
    
    /**
     * @brief Get module config
     **/
    function getConfig() {
        // Get module config from database
        $oModuleModel = getModel('module');
        $config = $oModuleModel->getModuleConfig('rating');
        
        // Set default values if not set
        if(!$config) {
            $config = new stdClass();
        }
        
        if(!isset($config->display_stars)) $config->display_stars = 'Y';
        if(!isset($config->allow_guests)) $config->allow_guests = 'N';
        if(!isset($config->max_rating)) $config->max_rating = 10;
        if(!isset($config->target_modules)) $config->target_modules = array();
        
        return $config;
    }
    
    /**
     * @brief Get rating by member
     **/
    function getRatingByMember($document_srl, $member_srl) {
        $args = new stdClass();
        $args->document_srl = $document_srl;
        $args->member_srl = $member_srl;
        return executeQuery('rating.getRatingByMember', $args);
    }
    
    /**
     * @brief Get document rating average
     **/
    function getDocumentRatingAverage($document_srl) {
        $args = new stdClass();
        $args->document_srl = $document_srl;
        $output = executeQuery('rating.getDocumentRatingAverage', $args);
        
        $avg = new stdClass();
        $avg->avg = $output->data->avg ? $output->data->avg : 0;
        $avg->count = $output->data->count ? $output->data->count : 0;
        
        return $avg;
    }
    
    /**
     * @brief Get document rating list
     **/
    function getDocumentRatingList($document_srl) {
        $args = new stdClass();
        $args->document_srl = $document_srl;
        $output = executeQuery('rating.getDocumentRatingList', $args);
        
        return $output;
    }
    
    /**
     * @brief Get all ratings list
     **/
    function getRatingList($page = 1, $items_per_page = 20) {
        $args = new stdClass();
        $args->page = $page;
        $args->list_count = $items_per_page;
        $args->page_count = 10;
        $args->sort_index = 'regdate';
        $args->order_type = 'desc';
        
        return executeQueryPage('rating.getRatingList', $args);
    }
}