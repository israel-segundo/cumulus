<?php
    echo $this->Html->css('/cumulus/css/style.css');

    $total_nodes=0;

    if( isset($tags) ){
        foreach( $tags as $tag){
            $total_nodes+=$tag['count'];
        }
        $links = '<tags>';
        foreach( $tags as $tag){
            $font_size=10;
            if($total_nodes!=0)
            {
                $font_size=10 + ($tag['count']/$total_nodes)*15;
            }
            $links .=$html->link($tag['title'], array(
                        'plugin'=>false,
                        'controller' => 'nodes',
                        'action' => 'term',
                        'type'   => $tag['type'],
                        'slug' => $tag['slug'],
                    ),array( 'class' => 'tag-link-79', 'style' => "style='font-size: ".$font_size."pt;"));
        }
        $links .= '</tags>';

    }else{
        $links = '<tags></tags>';
    }
?>
<div class="cumulus-tag-cloud">
    <object
        type="application/x-shockwave-flash"
        width="260"
        height="200" data="<?php echo $this->Html->url('/');?>cumulus/flash/tagcloud.swf">

        <param name="movie" value="<?php echo $this->Html->url('/');?>cumulus/flash/tagcloud.swf" />
        <param name="bgcolor" value="#ffffff" /><param name="AllowScriptAccess" value="always" />
        <param name="wmode" value="transparent" />
        <param name="flashvars"
               value="tcolor=0x111111&amp;tcolor2=0x336699&amp;hicolor=0x&amp;tspeed=100&amp;distr=true&amp;mode=both&amp;tagcloud=<?php echo urlencode($links); ?>" />
    </object>
</div>