<?php
/*
 * Plugin Name: Blog_tools
 * Plugin URI: http://www.wordpress.org/plugins/blog_tools
 * Description: A Comprehensive Tool for Blogs.
 * Version: 1.0
 * Author: Deven Bansod
 * Author URI: http://www.facebook.com/bansoddeven
 * License: GPL2
 */

define( POST_VIEWS_PLUGIN_URL ,  plugin_dir_url( __FILE__ ) );
define( SITE_URL , get_site_url() );


function Blog_tools($text) {
        
		//Gets the Meta Data for the Post.
        $post_meta_views = get_post_meta( get_the_id(), 'Page_views' );
	    
	    $post_meta_last_view = get_post_meta( get_the_id(), 'Last_view');
		
		$ip_new= $_SERVER['REMOTE_ADDR'];
        
		//If Post is viewed first time
        if ( $post_meta_views == NULL ) {
            
            //Checks if there exists Some data for the post/page and adds if not.
            add_post_meta(get_the_id(),'Page_views',1,TRUE);
            

            //Gets the newly added Meta data for the post/page.
            $post_meta_views = get_post_meta(get_the_id(),'Page_views');
        
        }

		if( $post_meta_last_view == NULL ) {
		    
		    $current_date = date('Y/m/d H:i:s');
		    
		    //Checks if there exists Some data for the post/page and adds if not.
		    add_post_meta( get_the_id(), 'Last_view', $current_date, TRUE);
		    
		    //Gets the newly added Meta data for the post/page. 
		    $post_meta_last_view = get_post_meta(get_the_id(),'Last_view');
		
		}
        

		//Checks if page is specifically one post/page . If Yes, Updates the new Post/page Views and The new Last views
        if( is_singular() ) {
        

            $post_meta_views[0] = $post_meta_views[0] + 1;
            
            //Increases the Count of the views
            update_post_meta( get_the_id(), 'Page_views', $post_meta_views[0]);
	    	
	    	$current_date=date('Y/m/d H:i:s');
	    
	    	$ip_new=$_SERVER['REMOTE_ADDR'];
	    	
	    	update_post_meta(get_the_id(),'Last_view',$post_meta_last_view);
	    	
	    	update_post_meta(get_the_id(),'Last_ip',$ip_new);
        
        }


        // Rendering the Final Output

        $post_views_output = "<a  href='" . SITE_URL . "/wp-admin/options-general.php?page=Blog_tools' class='entry-meta' style='text-align:center'><b>Post Views</a></b> = " . $post_meta_views[0];
      	
		$post_views_output = $post_views_output . "<a  href='" . SITE_URL . "/wp-admin/options-general.php?page=Blog_Tools' class='entry-meta' style='text-align:center'>Last viewed on</a> = <b>" . $post_meta_last_view[0] . "</b></br>";//Echoes Last Seen of the Post/page.

        $final_output = $post_views_output . "</br>" . $text;   //Echoes the rest of the Content of the Post/page
        
        return $final_output;	
	
	}



function add_options_blog_tools () {
	
	    add_options_page("Blog_Tools", "Blog_Tools", 1, "Blog_Tools", "Blog_tools_admin");
	
	}


function Blog_tools_admin() {
    
    include 'blog_tools_admin.php';
	
	}


add_action('the_content','Blog_tools');//Calls the plugin function.

add_action('admin_menu','add_options4');//Adds options page	


?>
