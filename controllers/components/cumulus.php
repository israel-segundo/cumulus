<?php
/**
 * Example Component
 *
 * An example hook component for demonstrating hook system.
 *
 * @category Component
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class CumulusComponent extends Object {
/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param object $controller Controller with components to startup
 * @return void
 */
    public function startup(&$controller) {
    }
/**
 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
 * Controller::render()
 *
 * @param object $controller Controller with components to beforeRender
 * @return void
 */
    public function beforeRender(&$controller) {
        $controller->set( 'tags', $this->extract_tags($controller) );
    }
/**
 * Called after Controller::render() and before the output is printed to the browser.
 *
 * @param object $controller Controller with components to shutdown
 * @return void
 */
    public function shutdown(&$controller) {
    }

    public function extract_tags(&$controller){

        $controller->loadModel('Taxonomy');
        $controller->Taxonomy->bindModel(array('hasAndBelongsToMany'=>array('Node')));
        $taxonomies = $controller->Taxonomy->find('all', array( 'conditions' => array( 'Vocabulary.alias'=> 'tags')) );

        $tags = array();
        foreach($taxonomies as $taxonomy){

            array_push($tags, array(
                'id'    => $taxonomy['Term']['id'],
                'slug'  => $taxonomy['Term']['slug'],
                'count' => count($taxonomy['Node']),
                'title' => $taxonomy['Term']['title']
            ));
        }
        
        return $tags;
    }

}
?>
