<?php

class CumulusActivation {

    public function beforeActivation(&$controller) {
        return true;
    }

    public function onActivation(&$controller) {
        
        $controller->Croogo->addAco('Cumulus');
        $controller->Croogo->addAco('Cumulus/admin_index'); 
        $controller->Croogo->addAco('Cumulus/index', array('registered', 'public'));

        $this->createBlock($controller);
    }

    public function beforeDeactivation(&$controller) {
        return true;
    }

    public function onDeactivation(&$controller) {
        
        $controller->Croogo->removeAco('Cumulus');
        $this->removeBlock($controller);
    }
    public function createBlock(&$controller){

        $controller->loadModel('Block');
        $controller->Block->create();
        $controller->Block->set(array(
            'visibility_roles' => $controller->Node->encodeData(array("1","2","3","4","5","6")),
            'visibility_paths' => '',
            'region_id'        => 4, // Right
            'title'            => 'Cumulus',
            'alias'            => 'cumulus_plugin',
            'body'             => '[element:cumulus_tag plugin="cumulus"]',
            'show_title'       => 1,
            'status'           => 1
        ));
        $controller->Block->save();
    }

    public function removeBlock(&$controller){

        $controller->loadModel('Block');
        $block = $controller->Block->find('first', array('conditions'=>array('Block.alias'=>'cumulus_plugin')));

        if( $block ){
            $controller->Block->delete($block['Block']['id']);
        }

    }
}
?>