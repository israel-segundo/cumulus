<?php

class CumulusComponent extends Object {

    public function startup(&$controller) {
    }

    public function beforeRender(&$controller) {
        $controller->set( 'tags', $this->extract_tags($controller) );
    }

    public function shutdown(&$controller) {
    }

    public function extract_tags(&$controller){

        $controller->loadModel('Taxonomy');
        $controller->loadModel('Node');

        $controller->Taxonomy->bindModel(array('hasAndBelongsToMany'=>array('Node')));
        $taxonomies = $controller->Taxonomy->find('all', array( 'conditions' => array( 'Vocabulary.alias'=> 'tags')) );

        $tags = array();

        foreach($taxonomies as $taxonomy){

            $types           = array();
            $nodes_with_term = $taxonomy['Node'];

            foreach( $nodes_with_term as $node ){

                $type = $node['type'];

                if( !isset( $types[$type] ) ){
                    array_push($types, $type);
                }
            }

            foreach( $types as $type ){
                array_push($tags, array(
                    'id'    => $taxonomy['Term']['id'],
                    'type'  => $type,
                    'slug'  => $taxonomy['Term']['slug'],
                    'count' => count($taxonomy['Node']),
                    'title' => $taxonomy['Term']['title']
                ));
            }
        }

        return $tags;
    }

}
?>
