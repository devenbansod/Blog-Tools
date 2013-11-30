<?php session_start();?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>Blog Tools' Settings</h2>
<?php
/*
 * This is the File for options page for the Plugin Blog Tools.
 * The Plugin views the 'Post views' and 'Last View at time' just below the Title of the Post/Page.
 * In the Admin area(Settins->Blog_tools), It shows the tables for Posts' Views along with the Author Name, Last View at, and IP of the last   
 * viewer.
 * This may help you to Judge your various Authors and may also get the Idea of the tastes of their readers.
 * It may also help you decide the current Popularity of a post among your readers.
 */
global $wpdb;
$n=wp_count_posts('post');
$i=1;
if(isset($_GET['do_changes']))
    {
        $a=$_POST['option1'];	
    	$r= get_page_by_title($a,ARRAY_N,'post');
    	update_post_meta($r[0],'Page_views',1);
    	echo '<input type=hidden name="changed" value="'.$a.'">';	
	$_SESSION['done']=$a;
    	header('location:options-general.php?page=Blog_Tools');
    }
echo '<h2></br>Current Statistics : </h2></br>
    <div style="margin-left : 4%"><table border =1 style="margin-left : 10%;border-collapse:collapse; 
    text-align: center;font-size: 120%" class="table_admin">
    <th>S.No.</th>
    <th>Post Name</th>
    <th>Author Name</th>
    <th>Post Views</th>
    <th>Last View on</th>
    <th>Last view from :</th>';
$k=$wpdb->get_results( "SELECT id FROM wp_posts where post_status ='publish'",ARRAY_N);
for($i=1;$i<=$n->publish;$i++){
    $g=$k[$i][0];
    $m=$wpdb->get_results("SELECT post_author FROM wp_posts where ID = '$g'",ARRAY_N);
    $h=$m[0][0];
    $f=$wpdb->get_results("SELECT display_name FROM wp_users where ID = '$h'",ARRAY_N);
    $l=get_post_meta($k[$i][0],'Page_views');
    $q=get_post_meta($k[$i][0],'Last_view');
    $ip=get_post_meta($k[$i][0],'Last_ip');
    echo '<tr><td>'.$i.'</td>
        <td>'.get_the_title($k[$i][0]).'</td>
        <td>'.$f[0][0].'</td> 
        <td>'.$l[0].'</td>
	<td>'.$q[0].'</td>
	<td>'.$ip[0].'</td>
	</tr>';

}
echo '</table></div>';
    echo "<h4 style='margin-left:11%'>Select a post that You want to reinitate Post views for and Press Submit : </h4>";
echo '<div style="margin-left : 22%"></br>
    <form method = "POST" action="options-general.php?page=Blog_Tools&do_changes">
    <select name="option1">';
$t=$wpdb->get_results( "SELECT id FROM wp_posts where post_status ='publish'",ARRAY_N);
for($i=1;$i<=$n->publish;$i++){
    $l=get_post_meta($t[$i][0],'Page_views');
    echo '<option>'.get_the_title($t[$i][0]).'</option>';
    
}
    echo '</select>';
    submit_button('Submit');      
if(isset($_SESSION['done']))
    {
        $a=$_SESSION['done'];
        echo "</br></br></div><p style='margin-left:10%;font-size:120%'>The Post Views of the post titled 
            '<b>".$a."</b>' have been reinitiated to 1</br></p>";
	unset($_SESSION['done']);
    }
?>
