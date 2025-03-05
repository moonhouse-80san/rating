<?php
/**
 * @class ratingAdminView
 * @author Claude AI
 * @brief Admin view class for rating module
 **/
class ratingAdminView extends rating {
    /**
     * @brief Initialization
     **/
    function init() {
        // Set template path
        $this->setTemplatePath($this->module_path.'tpl/admin');
        
        // Get module model and module info
        $oModuleModel = getModel('module');
        $this->module_info = $oModuleModel->getModuleInfoByMid('rating');
        
        // Set layout
        $this->setLayoutPath('./modules/admin/tpl');
        $this->setLayoutFile('layout');
    }
    
    /**
     * @brief Admin main page
     **/
    function dispRatingAdminIndex() {
        // Get module instance list
        $oModuleModel = getModel('module');
        $module_list = $oModuleModel->getMidList();
        Context::set('module_list', $module_list);
        
        // Get config
        $oRatingModel = getModel('rating');
        $config = $oRatingModel->getConfig();
        Context::set('config', $config);
        
        // Set template file
        $this->setTemplateFile('index');
    }
    
    /**
     * @brief Display list of ratings
     **/
    function dispRatingAdminList() {
        // Pagination
        $page = Context::get('page') ?? 1;
        $items_per_page = 20;
        
        // Get ratings
        $oRatingModel = getModel('rating');
        $output = $oRatingModel->getRatingList($page, $items_per_page);
        Context::set('rating_list', $output->data);
        Context::set('page_navigation', $output->page_navigation);
        
        // Set template file
        $this->setTemplateFile('rating_list');
    }
}