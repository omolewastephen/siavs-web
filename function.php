<?php
$db = new DB();

function notification($msg,$type){
	$upper = strtoupper($type);
	return '
		<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
		  <strong>'.$upper.'!</strong> '.$msg.'
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	';
}

function redirect($url){
	ob_start();
	header('location:'.$url);
}

function clean($data){
	$data = trim($data);
	$data = stripslashes($data);
	return $data;
}

function if_exist($user,$pass)
{
  global $db;
	$stmt = $db->single("SELECT * FROM admin WHERE username = '{$user}' AND password = '{$pass}' LIMIT 1 ");
	$count = $db->rowcount();
	return($count > 0) ? true:false;
}

function login($user,$pass)
{
  global $db;
	if(if_exist($user,$pass)){
		$stmt = $db->single("SELECT * FROM admin WHERE username = '{$user}' AND password = '{$pass}' LIMIT 1 ");
		$count = $db->rowcount();
		if($count == 1){
			$id = $stmt->id;
			$username = $stmt->username;

			$_SESSION['sess_id'] = $id;
			$_SESSION['sess_username'] = $username;
			redirect('home.php');
		}
	}
}

function is_connected(){
	$connected = @fsockopen("www.google.com",80);
	if($connected){
		$is_conn = true;
		fclose($connected);
	}else{
		$is_conn = false;
	}

	return $is_conn;
}

function is_sms_enabled()
{
    global $db;
    $stmt = $db->single("SELECT sms_status FROM admin ");
    $staus = $stmt->sms_status;
    return($status == 1) ? true:false;
}

function curl_get_contents($url){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_URL,$url);

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

// Send Message to Parent Phone
function sendmessage($message,$phone,$sch,$parentname,$childname,$username,$password,$std_type,$msgtype){
        $type = '';
	    switch ($std_type) {
            case 'Day':
                if($msgtype == 'Arrival'){
                    $type = 'has arrived in School';
                }else{
                    $type = 'has left the School';
                }
                
                break;
             case 'Boarding':
                if($msgtype == 'Arrival'){
                    $type = 'has left the School Hostel';
                }else{
                    $type = 'has returned to the Hostel';
                }
                break;
        }
		$replace = array('_PARENT_' ,'_CHILD_','_TYPE_');
		$replace_ = array( strtoupper($parentname) , strtoupper($childname), $type );
		$sms = str_replace($replace, $replace_, $message) ;

		$url = "http://www.peaksms.org/com_sms/smsapi.php?username=".$username."&password=".$password."&sender=".$sch."&recipient=".$phone."&message=".$sms;

		$url = str_replace(" ", "%20", $url);
		$result = curl_get_contents($url);

		return ($result === 'Success')? true: false;

}

function sendmessageB($message,$phone,$sch,$parentname,$childname,$username,$password,$std_type){
        $type = '';
        switch ($std_type) {
            case 'Day':
                $type = 'School';
                break;
             case 'Boarding':
                $type = 'Hostel';
                break;
        }
        $replace = array('_PARENT_' ,'_CHILD_','_TYPE_');
        $replace_ = array( strtoupper($parentname) , strtoupper($childname), strtoupper($type) );
        $sms = str_replace($replace, $replace_, $message) ;

        $url = "http://www.peaksms.org/com_sms/smsapi.php?username=".$username."&password=".$password."&sender=".$sch."&recipient=".$phone."&message=".$sms;

        $url = str_replace(" ", "%20", $url);
        $result = curl_get_contents($url);

        return ($result === 'Success')? true: false;

}

if(!function_exists('http_build_url'))
        {
            // Define constants
            define('HTTP_URL_REPLACE',          0x0001);    // Replace every part of the first URL when there's one of the second URL
            define('HTTP_URL_JOIN_PATH',        0x0002);    // Join relative paths
            define('HTTP_URL_JOIN_QUERY',       0x0004);    // Join query strings
            define('HTTP_URL_STRIP_USER',       0x0008);    // Strip any user authentication information
            define('HTTP_URL_STRIP_PASS',       0x0010);    // Strip any password authentication information
            define('HTTP_URL_STRIP_PORT',       0x0020);    // Strip explicit port numbers
            define('HTTP_URL_STRIP_PATH',       0x0040);    // Strip complete path
            define('HTTP_URL_STRIP_QUERY',      0x0080);    // Strip query string
            define('HTTP_URL_STRIP_FRAGMENT',   0x0100);    // Strip any fragments (#identifier)

            // Combination constants
            define('HTTP_URL_STRIP_AUTH',       HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS);
            define('HTTP_URL_STRIP_ALL',        HTTP_URL_STRIP_AUTH | HTTP_URL_STRIP_PORT | HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT);

            /**
             * HTTP Build URL
             * Combines arrays in the form of parse_url() into a new string based on specific options
             * @name http_build_url
             * @param string|array $url     The existing URL as a string or result from parse_url
             * @param string|array $parts   Same as $url
             * @param int $flags            URLs are combined based on these
             * @param array &$new_url       If set, filled with array version of new url
             * @return string
             */
            function http_build_url(/*string|array*/ $url, /*string|array*/ $parts = array(), /*int*/ $flags = HTTP_URL_REPLACE, /*array*/ &$new_url = false)
            {
                // If the $url is a string
                if(is_string($url))
                {
                    $url = parse_url($url);
                }

                // If the $parts is a string
                if(is_string($parts))
                {
                    $parts  = parse_url($parts);
                }

                // Scheme and Host are always replaced
                if(isset($parts['scheme'])) $url['scheme']  = $parts['scheme'];
                if(isset($parts['host']))   $url['host']    = $parts['host'];

                // (If applicable) Replace the original URL with it's new parts
                if(HTTP_URL_REPLACE & $flags)
                {
                    // Go through each possible key
                    foreach(array('user','pass','port','path','query','fragment') as $key)
                    {
                        // If it's set in $parts, replace it in $url
                        if(isset($parts[$key])) $url[$key]  = $parts[$key];
                    }
                }
                else
                {
                    // Join the original URL path with the new path
                    if(isset($parts['path']) && (HTTP_URL_JOIN_PATH & $flags))
                    {
                        if(isset($url['path']) && $url['path'] != '')
                        {
                            // If the URL doesn't start with a slash, we need to merge
                            if($url['path'][0] != '/')
                            {
                                // If the path ends with a slash, store as is
                                if('/' == $parts['path'][strlen($parts['path'])-1])
                                {
                                    $sBasePath  = $parts['path'];
                                }
                                // Else trim off the file
                                else
                                {
                                    // Get just the base directory
                                    $sBasePath  = dirname($parts['path']);
                                }

                                // If it's empty
                                if('' == $sBasePath)    $sBasePath  = '/';

                                // Add the two together
                                $url['path']    = $sBasePath . $url['path'];

                                // Free memory
                                unset($sBasePath);
                            }

                            if(false !== strpos($url['path'], './'))
                            {
                                // Remove any '../' and their directories
                                while(preg_match('/\w+\/\.\.\//', $url['path'])){
                                    $url['path']    = preg_replace('/\w+\/\.\.\//', '', $url['path']);
                                }

                                // Remove any './'
                                $url['path']    = str_replace('./', '', $url['path']);
                            }
                        }
                        else
                        {
                            $url['path']    = $parts['path'];
                        }
                    }

                    // Join the original query string with the new query string
                    if(isset($parts['query']) && (HTTP_URL_JOIN_QUERY & $flags))
                    {
                        if (isset($url['query']))   $url['query']   .= '&' . $parts['query'];
                        else                        $url['query']   = $parts['query'];
                    }
                }

                // Strips all the applicable sections of the URL
                if(HTTP_URL_STRIP_USER & $flags)        unset($url['user']);
                if(HTTP_URL_STRIP_PASS & $flags)        unset($url['pass']);
                if(HTTP_URL_STRIP_PORT & $flags)        unset($url['port']);
                if(HTTP_URL_STRIP_PATH & $flags)        unset($url['path']);
                if(HTTP_URL_STRIP_QUERY & $flags)       unset($url['query']);
                if(HTTP_URL_STRIP_FRAGMENT & $flags)    unset($url['fragment']);

                // Store the new associative array in $new_url
                $new_url    = $url;

                // Combine the new elements into a string and return it
                return
                     ((isset($url['scheme'])) ? $url['scheme'] . '://' : '')
                    .((isset($url['user'])) ? $url['user'] . ((isset($url['pass'])) ? ':' . $url['pass'] : '') .'@' : '')
                    .((isset($url['host'])) ? $url['host'] : '')
                    .((isset($url['port'])) ? ':' . $url['port'] : '')
                    .((isset($url['path'])) ? $url['path'] : '')
                    .((isset($url['query'])) ? '?' . $url['query'] : '')
                    .((isset($url['fragment'])) ? '#' . $url['fragment'] : '');
                    }
                }

function stripUrlImage($url){
	$parts = parse_url($url);
	$parts['host'] = $_SERVER['HTTP_HOST'];
	$final = http_build_url($parts);
	return $final;

}

