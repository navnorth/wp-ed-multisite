<?php
include_once wp_normalize_path( get_stylesheet_directory() . '/vendor/autoload.php' );

use JonathanTorres\MediumSdk\Medium;

class MediumAuthException extends Exception{
    public function errorMessage(){
        $error = 'Error on line '. $this->getLine().' in ' . $this->getFile() .': <b>'.$this->getMessage().'</b> Unable to authenticate through Medium';
        return $error;
    }
}


class OET_Medium {

    private $_access_token;
    private $_user;
    private $_medium;
    private $_base_url = "https://medium.com/";
    private $_publications;
    private $_rss_urls = array();
    private $_feeds = array();
    private $_display;

    public function __construct($self_access_token = null, $auth = true){
        if ($self_access_token){
            $this->_access_token = $self_access_token;
        } else {
            $this->_access_token = get_option("mediumaccesstoken");
        }
        if ($auth)
            $this->authenticate();
    }

    // Authentication Medium Access Token
    private function authenticate(){
        if ($this->_access_token) {
            // Self Access Token Authentication
            $this->_medium = new Medium($this->_access_token);
            $this->_user = $this->_medium->getAuthenticatedUser();
        } else {
            throw new MediumAuthException('Invalid Self Access Token');
        }
    }
    
    // Return Authenticated User
    public function get_authenticated_user(){
        $user = null;
        
        if (isset($this->_user))
            $user = $this->_user;
            
         return $user;
    }
    
    // Debug Medium Connection
    public function debug_medium_connection(){
        $limit = 100;
        $all_url = $this->_base_url."@".$this->_user->data->username."/latest?format=json&limit=".$limit;
        
        ob_start();
        $log = fopen("php://output","w");
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $all_url);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, $log);
        
        $response = curl_exec($ch);
        
        fclose($log);
        
        if ($response === FALSE) {
            return printf("cUrl error (#%d): %s<br>\n", curl_errno($handle),
            htmlspecialchars(curl_error($handle)));
        }

        $debug = ob_get_clean();

        $ret =  "<h5>Debugging connection:</h5>\n<pre>". htmlspecialchars($debug). "</pre>\n";
        return $ret;
    }

    // Get Medium Publications based on authenticated user
    public function get_publications(){
        if ($this->_user){
            $this->_publications = $this->_medium->publications($this->_user->data->id)->data;
            return $this->_publications;
        } else {
            throw new Exception('Medium User Not Authenticated');
        }
    }

    // Get RSS Urls
    private function get_rss_urls(){
        global $post;
        $this->_display = get_post_meta($post->ID,"mpubdisplay",true);
        if ($this->_user){
            if ($this->_display=="all"){
                $this->_rss_urls[] = array(
                    "feed_url" => $this->_base_url."feed/@".$this->_user->data->username
                );
            }

            if ($this->_publications){
                $i = 1;
                foreach($this->_publications as $publication){
                    $pub_name = sanitize_title($publication->name);
                    if (strpos($publication->url,$this->_base_url)>=0)
                        $pub_name = trim(substr($publication->url,strlen($this->_base_url),strlen($publication->url)));

                        if (get_post_meta($post->ID, "mpublication".$i, true)=="1")
                            $this->_rss_urls[] = array(
                                    "feed_url" => $this->_base_url."feed/".$pub_name,
                                    "name" => $publication->name,
                                    "url" => $publication->url
                                   );
                    $i++;
                }
            } else {
                throw new Exception('Invalid User Publications');
            }
            return $this->_rss_urls;
        } else {
            throw new Exception('Medium User Not Authenticated');
        }
    }

    // Get Feeds
    private function get_feeds($rss_urls = array()){
        if (count($this->_rss_urls)>0) {
            foreach ($this->_rss_urls as $rss_url){
                $feed = convert_rss_to_json($rss_url["feed_url"]);
                if ($feed){
                    if ($feed['status']=="ok"){
                        foreach($feed['items'] as $item){
                            $titles = array_column($this->_feeds,"title");
                            $title_exists = array_search($item['title'], $titles);
                            if (!$title_exists) {
                                if (isset($rss_url["name"]))
                                   $this->_feeds[] = array_merge($item, array("pub_name"=>$rss_url["name"],"pub_url"=>$rss_url["url"])) ;
                                else
                                   $this->_feeds[] = $item;
                            }
                        }
                    }
                }
            }

            return $this->_feeds;
        } else {
            throw new Exception('No RSS Url Specified!');
        }
    }

    function return_unique($feeds, $key){
        $temp_array = [];
        foreach ($feeds as &$v) {
            if (!isset($temp_array[$v[$key]]))
            $temp_array[$v[$key]] =& $v;
        }
        $feeds = array_values($temp_array);
        return $feeds;
    }

    // Get Medium Stories via JSON
    function get_medium_stories(){
        $limit = 100;
        $all_url = $this->_base_url."@".$this->_user->data->username."/latest?format=json&limit=".$limit;
        $data = get_medium_posts_json($all_url);
        $feeds = array();
        $index = 0;
        if ($this->isJson($data)){
            foreach($data['payload']['references']['Post'] as $post){
                $feeds[]=$post;
            }
            return $feeds;
        } else {
            return false;
        }
    }
    
    // Get Medium Stories via JSON
    function get_medium_story($url){
        $data = get_medium_posts_json($url);
        if (!empty($data)){
            return $data;
        }
    }
    
    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    // Display All Medium Posts
    public function display_posts(){
        $publications = $this->get_publications();
        $rss_urls = $this->get_rss_urls();
        $feeds = $this->get_feeds();

        if ($this->_feeds) {
            $fcnt = 1;
            foreach($this->_feeds as $feed) {
                $description = strip_tags_content($feed['description'],"<h3>","</h3>");
                $description = strip_tags_content($description,"<figure>","</figure>");
                $description = trim(strip_tags($description));
                if (strlen($description)>175){
                    $description = substr($description,0,175);
                    $description = substr($description,0,strrpos($description," "))."...";
                }

                $background = "";
                if (substr($feed['thumbnail'],0,11)=="https://cdn")
                    $background = "background:#000000 url(". $feed['thumbnail'] .") no-repeat top left;";
                elseif (substr($feed['thumbnail'],0,11)=="https://med")
                    $background = "background:#757575";

                $title = $feed['title'];
                if (strlen($title)>80){
                    $title = substr($title,0,80);
                    $title = substr($title,0,strrpos($title," "))."...";
                }
            ?>
            <div class="col-md-4 col-sm-6 col-xs-12 medium-list">
                <div class="medium" style="<?php echo $background; ?>">
                    <div class="medium-background">
                        <div class="medium-wrapper">
                            <h1><a href="<?php echo $feed['link']; ?>" target="_blank" onclick="gtag('event','Medium Blog Post Click',{'medium_post_url':'<?php echo $feed['link']; ?>'});"><?php echo $title; ?></a></h1>
                            <p><?php echo $description ?></p>
                            <p class="mfooter">
                                <?php if ($feed['author']=="Office of Ed Tech"): ?>
                                <a href="<?php echo $this->_user->data->url; ?>" alt="<?php _e('Office of Educational Technology logo','twentytwelve-child'); ?>" target="_blank" class="imglink" onclick="gtag('event','Medium Blog Author Click',{'blog_author_url':'<?php echo $this->_user->data->url; ?>'});"><img src="<?php echo $this->_user->data->imageUrl; ?>" alt="<?php _e('Office of Educational Technology logo','twentytwelve-child'); ?>" width="30" height="30" /></a> <a href="<?php echo $this->_user->data->url; ?>" target="_blank" onclick="gtag('event','Medium Blog Author Click',{'blog_author_url':'<?php echo $this->_user->data->url; ?>'});">@<?php echo $this->_user->data->username; ?></a> in
                                <?php endif; ?>
                                <?php if (isset($feed["pub_name"])){ ?>
                                 <a href="<?php echo $feed["pub_url"]; ?>" alt="<?php echo $feed["pub_name"]; ?>" title="<?php echo $feed["pub_name"]; ?>" target="_blank" onclick="gtag('event','Medium Blog Publication Click',{'blog_publication_url':'<?php echo $feed['pub_url']; ?>'});"><?php echo $feed["pub_name"]; ?></a>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $fcnt++;
            }
        } else {
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12 medium-error">
                <div class="archived-disclaimer">
			Medium integration temporarily unavailable - <a href="https://medium.com/@OfficeofEdTech" target="_blank">Visit our Blog</a>
		</div>
            </div>
            <?php
        }
    }

    // Display All Stories
    public function display_all_stories(){
        $feeds = $this->get_medium_stories();
        if ($feeds){
            foreach($feeds as $feed){
                $link_url = $this->_base_url."@".$this->_user->data->username."/".$feed['uniqueSlug'];
                $title = $feed['title'];
                if (strlen($title)>80){
                    $title = substr($title,0,80);
                    $title = substr($title,0,strrpos($title," "))."...";
                }

                if (isset($feed['content']['metaDescription']))
                    $description = $feed['content']['metaDescription'];
                else
                    $description = $feed['content']['subtitle'];

                $description = strip_tags_content($description,"<h3>","</h3>");
                $description = strip_tags_content($description,"<figure>","</figure>");
                $description = trim(strip_tags($description));

                if (strlen($description)>175){
                    $description = substr($description,0,175);
                    $description = substr($description,0,strrpos($description," "))."...";
                }

                $background = "";
                if (isset($feed['virtuals']['previewImage']['imageId'])){
                    $cdn_base = "https://cdn-images-1.medium.com/max/1024/";
                    $background = "background:#000000 url(". $cdn_base.$feed['virtuals']['previewImage']['imageId'] .") no-repeat top left;";
                } else
                    $background = "background:#757575";

                $story['title'] = $title;
                $story['description'] = $description;
                $story['background'] =  $background;
                $story['align'] = $align;
                $story['link'] = $link_url;
                ?>
                <div class="col-md-4 col-sm-6 col-xs-12 medium-list">
                    <div class="medium" style="<?php echo $background; ?>">
                        <div class="medium-background">
                            <div class="medium-wrapper">
                                <h1><a href="<?php echo $link_url; ?>" target="_blank" onclick="gtag('event','Medium Blog Post Click',{'event_category':'<?php echo $link_url; ?>'});"><?php echo $title; ?></a></h1>
                                <p><?php echo $description ?></p>
                                <p class="mfooter">
                                    <a href="<?php echo $this->_user->data->url; ?>" alt="<?php _e('Office of Educational Technology logo','twentytwelve-child'); ?>" target="_blank" class="imglink" onclick="gtag('event','Medium Blog Author Click',{'blog_author_url':'<?php echo $this->_user->data->url; ?>'});"><img src="<?php echo $this->_user->data->imageUrl; ?>" alt="<?php _e('Office of Educational Technology logo','twentytwelve-child'); ?>" width="30" height="30" /></a> <a href="<?php echo $this->_user->data->url; ?>" target="_blank" onclick="gtag('event','Medium Blog Author Click',{'blog_author_url':'<?php echo $this->_user->data->url; ?>'});">@<?php echo $this->_user->data->username; ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12 medium-error">
                <div class="archived-disclaimer">
			Medium integration temporarily unavailable - <a href="https://medium.com/@OfficeofEdTech" target="_blank">Visit our Blog</a>
		</div>
            </div>
            <?php
        }
    }

    // Display Individual Post by Url
    public function display_post($url, $attribute){
        if (is_array($attribute))
            extract($attribute);
            
        try{
            $publications = $this->get_publications();
            $rss_urls = $this->get_rss_urls();
            
            $match = false;
    
            $find_url = parse_url($url);
            $post_url = $find_url['scheme']."://".$find_url['host'].$find_url['path'];
            $story = null;
    
            if (strpos($url,"@".$this->_user->data->username)){
                $feeds = $this->get_medium_stories();
                if ($feeds){
                    foreach($feeds as $feed){
                        $link_url = $find_url['scheme']."://".$find_url['host']."/@".$this->_user->data->username."/".$feed['uniqueSlug'];
                        if ($post_url==$link_url){
                            $match = true;
    
                            $title = $feed['title'];
                            if (strlen($title)>80){
                                $title = substr($title,0,80);
                                $title = substr($title,0,strrpos($title," "))."...";
                            }
    
                            if (isset($feed['content']['metaDescription']))
                                $description = $feed['content']['metaDescription'];
                            else
                                $description = $feed['content']['subtitle'];
    
                            $description = strip_tags_content($description,"<h3>","</h3>");
                            $description = strip_tags_content($description,"<figure>","</figure>");
                            $description = trim(strip_tags($description));
    
                            if (strlen($description)>175){
                                $description = substr($description,0,175);
                                $description = substr($description,0,strrpos($description," "))."...";
                            }
    
                            $background = "";
                            if (isset($feed['virtuals']['previewImage']['imageId'])){
                                $cdn_base = "https://cdn-images-1.medium.com/max/1024/";
                                $background = "background:#000000 url(". $cdn_base.$feed['virtuals']['previewImage']['imageId'] .") no-repeat top left;";
                            } else
                                $background = "background:#757575";
    
                            $story['title'] = $title;
                            $story['description'] = $description;
                            $story['background'] =  $background;
                            $story['align'] = $align;
                            $story['link'] = $link_url;
                            break;
                        }
                    }
                } else {
                    return $this->display_post_by_jsonUrl($url);
                }
            } else {
                $feeds = $this->get_feeds();
                if ($this->_feeds) {
                    foreach($this->_feeds as $feed) {
                        $link = parse_url($feed[0]['link']);
                        $link_url = $link['scheme']."://".$link['host'].$link['path'];
    
                        if ($post_url==$link_url){
                            $match = true;
                            $description = strip_tags_content($feed[0]['description'],"<h3>","</h3>");
                            $description = strip_tags_content($description,"<figure>","</figure>");
                            $description = trim(strip_tags($description));
    
                            if (strlen($description)>175){
                                $description = substr($description,0,175);
                                $description = substr($description,0,strrpos($description," "))."...";
                            }
    
                            $background = "";
                            if (substr($feed[0]['thumbnail'],0,11)=="https://cdn")
                                $background = "background:#000000 url(". $feed[0]['thumbnail'] .") no-repeat top left;";
                            elseif (substr($feed[0]['thumbnail'],0,11)=="https://med")
                                $background = "background:#757575";
    
                            $title = $feed[0]['title'];
                            if (strlen($title)>80){
                                $title = substr($title,0,80);
                                $title = substr($title,0,strrpos($title," "))."...";
                            }
    
                            $story['description'] = $description;
                            $story['background'] =  $background;
                            $story['title'] = $title;
                            $story['align'] = $align;
                            $story['link'] = $feed[0]['link'];
                            $story['pub_name'] = $feed["pub_name"];
                            $story['pub_url'] = $feed["pub_url"];
                        break;
                        }
                    }
                }
            }
    
            if(!$match){
                return $this->display_medium_post_unavailable($url, $width);
            } else {
                return $this->display_single_embed($story);
            }
        } catch (Exception $e){
            return $this->display_medium_post_unavailable($url, $width);
        }
    }
    
    // Display Individual Post by Url
    public function display_post_by_jsonUrl($url, $attribute){
        if (is_array($attribute))
            extract($attribute);
            
        try{
            if (strpos($url,'?format=json')==FALSE)
                $url .= '/?format=json';
            $find_url = parse_url($url);
            $post_url = $find_url['scheme']."://".$find_url['host'].$find_url['path'];
            
            $feeds = $this->get_medium_story($url);
            
            if (!empty($feeds)) {
                $feed = $feeds['payload'];
                $description = strip_tags_content($feed['value']['content']['subtitle'],"<h3>","</h3>");
                $description = strip_tags_content($description,"<figure>","</figure>");
                $description = trim(strip_tags($description));
                
                if (strlen($description)>175){
                    $description = substr($description,0,175);
                    $description = substr($description,0,strrpos($description," "))."...";
                }

                $background = "";
                $url_path = "https://miro.medium.com/max/";
                if (isset($feed['value']['virtuals']['previewImage'])){
                    $pImage = $feed['value']['virtuals']['previewImage'];
                    $thumbnail_url = $url_path.$pImage['originalWidth']."/".$pImage['imageId'];
                    $background = "background:#000000 url(". $thumbnail_url .") no-repeat top left;";
                }

                $title = $feed['value']['title'];
                if (strlen($title)>80){
                    $title = substr($title,0,80);
                    $title = substr($title,0,strrpos($title," "))."...";
                }

                $story['description'] = $description;
                $story['background'] =  $background;
                $story['title'] = $title;
                $story['align'] = $align;
                $story['link'] = $feed['value']['mediumUrl'];
                $medium_path = "https://medium.com/";
                foreach($feed['references']['User'] as $user){
                    $story['user_name'] = $user['username'];
                    $story['user_url'] = $medium_path."@".$user['username'];
                    $story['user_logo'] = $user['imageId'];
                }
                if (isset($feed['references']['Collection'])){
                    foreach($feed['references']['Collection'] as $collection){
                        $story['pub_name'] = $collection['name'];
                        $story['pub_url'] = $medium_path.$collection['slug'];
                    }
                }
            }
            return $this->display_single_embed($story);
        } catch (Exception $e){
            return $this->display_medium_post_unavailable($url, $width);
        }
    }

    function display_single_embed($story){
        $logo_url = "";
        $logo_path = "https://miro.medium.com/fit/c/160/160/";
        if (isset($story['user_logo']))
            $logo_url = $logo_path . $story['user_logo'];
        if ($story['align']=='center')
            $align = 'margin:0 auto';
        else
            $align = 'float:'.$story['align'];
        $embed = '
        <div class="single-medium">
            <div class="medium" style="'.$story['background'].''.$align.'">
                <div class="medium-background">
                    <div class="medium-wrapper">
                        <h1><a href="'.$story['link'].'" target="_blank" onclick="gtag(\'event\',\'Medium Blog Click\',{\'medium_url\':\'' . $story['link'] . '\'});">'.$story['title'].'</a></h1>
                        <p>'.$story['description'].'</p>
                        <p class="mfooter">
                            <a href="'.$story["user_url"].'" alt="Office of Educational Technology logo" target="_blank" class="imglink" onclick="gtag(\'event\',\'Medium Blog Author Click\',{\'blog_author_url\':\'' . $story["user_url"] . '\'});"><img src="'.$logo_url.'" alt="Office of Educational Technology logo" width="30" height="30" /></a> <a href="'.$story["user_url"].'" target="_blank" onclick="gtag(\'event\',\'Medium Blog Author Click\',{\'blog_author_url\':\'' . $story["user_url"] . '\'});">@'.$story["user_name"].'</a> ';
                    if (isset($story["pub_name"]) && $story["pub_name"]!==""){
                        $embed .= 'in <a href="'.$story["pub_url"].'" alt="'.$story["pub_name"].'" title="'.$story["pub_name"].'" target="_blank" onclick="gtag(\'event\',\'Medium Blog Publication Click\',{\'blog_publication_url\':\'' . $story["pub_url"] . '\'});">'.$story["pub_name"].'</a>';
                    }
        $embed .= '     </p>
                    </div>
                </div>
            </div>
        </div>
        ';
        return $embed;
    }

    function display_invalid_text(){
        $background = "background:#757575";
        return $embed = '
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="medium" style="'.$background.'">
                <div class="medium-background">
                    <div class="medium-wrapper">
                        <p>Medium post invalid</p>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    
    function display_medium_post_unavailable($url, $width=""){
        $background = "background:#757575";
        $style = "";
        if ($width!=="")
            $style = ' style="width:'.$width.';"';
        return $embed = '
        <div class="col-md-4 col-sm-6 col-xs-12"'.$style.'>
            <div class="medium" style="'.$background.'">
                <div class="medium-background">
                    <div class="medium-wrapper">
                        <p>Medium integration temporarily unavailable - <a href="'.$url.'" target="_blank">Read the Article</a></p>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}


?>
