<?php

// Get Latest 10 Posts from a user.
class OET_Medium_Data {
	private $_base_url = "https://medium.com/";
	private $_medium_url;
	private $_medium_user = "@OfficeOfEdTech";
	private $_medium_feed_url = "https://medium.com/feed/@OfficeOfEdTech";
	private $_medium_data;

	public function __construct($medium_url = null){
        if ($medium_url)
        		$this->_medium_url = $medium_url;
        $this->_medium_data = $this->parse_medium_feeds($this->_medium_url);
    }

    // Parse Medium Feeds of user default(@OfficeOfEdTech)
    public function parse_medium_feeds($medium_url){
    	$medium_post = [];
    	$medium = simplexml_load_file($this->_medium_feed_url,'SimpleXMLElement', LIBXML_NOCDATA);
    	$i = 0;
    	for ($i=0;$i<10;$i++){
    		foreach($medium->channel->link as $link){
    			$medium_post[$i]['authorurl']  = (string)$link;
    		}
    		foreach($medium->channel->image->url as $url){
    			$medium_post[$i]['authorlogo']  = (string)preg_replace('/\?.*/', '', $url);
    		}
    		$medium_post[$i]['authorname']  = $this->_medium_user;
    		foreach($medium->channel->item[$i]->title as $title){
    			$medium_post[$i]['title']  =  (string)$title;
    		}
    		foreach($medium->channel->item[$i]->link as $link){
    			$medium_post[$i]['url']  = (string)preg_replace('/\?.*/', '', $link);
    		}
    		$content = $medium->channel->item[$i]->children('content', true);
    		$content_encoded = (string)$content->encoded;
    		$medium_post[$i]['description'] = $this->get_excerpt($content_encoded);
    	}
    	return $medium_post;
    }

    // Make first paragraph as excerpt
    private function get_excerpt($content){
    	$start = strpos($content, '<p>');
		$end = strpos($content, '</p>', $start);
		$excerpt = strip_tags(substr($content, $start, $end-$start+4));
		return $excerpt;
    }

    // Return medium post based on url
    public function get_medium_post(){
    	$medium_post = null;
    	if ($this->_medium_data){
    		foreach($this->_medium_data as $post){
    			if ($post['url']==$this->_medium_url){
    				$medium_post = $post;
    				break;
    			}
    		}
    	}
    	if (!$medium_post)
    		return "Medium post not found";
    	return $medium_post;
    }
}

?>