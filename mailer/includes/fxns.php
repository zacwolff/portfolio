<?


function redirect_to($action=null)
{
    $action = _link($action);
   header('location:'.$action );
  exit;
}

 /**
 * generates url link for 
 * @param string 'post' or 'get', 'p' or 'g'
 * @param string optional key  $key
 * @return bool true or false
 */
function _link($action = ""){
    
    if(trim($action) == '') : 
        $url ='?';
    elseif(trim($action)== '#'):
        $url ='#';
    else:
        $url = "?action=$action";
    endif;
    return $url;
}


 /**
 * generates url link for 
 * @param string 'post' or 'get', 'p' or 'g'
 * @param string optional key  $key
 * @return bool true or false
 */
function _link_custom($action = ""){
    
    if(trim($action) == '') : 
        $url ='?';
    elseif(trim($action)== '#'):
        $url ='#';
    else:
        $url = "$action";
    endif;
    return $url;
}
 //checks if post or get value is not null
 /**
 * Check for get post in requests
 * @param string 'post' or 'get', 'p' or 'g'
 * @param string optional key  $key
 * @return bool true or false
 */
 function check_post_get($post_or_get, $key = null, $value = null){
    if(trim($post_or_get) == 'get' || trim($post_or_get) == 'g'){
        if(isset($_GET[$key]) && trim($_GET[$key]) != ''){
            if(trim($value) != ''){
                if(trim($_GET[$key]) == "$value"){
                    return true;
                }
                return false;
            }
                return true;
            }
    }
    if(trim($post_or_get) == 'post' || trim($post_or_get) == 'p'){
        if(isset($_POST[$key]) && trim($_POST[$key]) != ''){
            if(trim($value) != ''){
                if(trim($_POST[$key]) == "$value"){
                    return true;
                }
                return false;
            }
                return true;
            }
    }
    return false;
}

function post_get($post_or_get, $key = null, $value = null){
    if(trim($post_or_get) == 'get' || trim($post_or_get) == 'g'){
        if(trim($post_or_get) == 'get' || trim($post_or_get) == 'g'){
            return trim($_GET[$key]);
        }
    }
    if(check_post_get($post_or_get) == 'post' || trim($post_or_get) == 'p'){
        if(trim($post_or_get) == 'post' || trim($post_or_get) == 'p'){
            return trim($_POST[$key]);
        }
    }
}


function json_response($message = null, $code = 200, $headers = [''])
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);

    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    if(count($headers) > 0):
        foreach($headers as $header => $value){
            header("$header: $value");
        }
    endif;
    $status = array(
        200 => '200 OK',
        201 => '201 Created',
        204 => '204 No Content',
        205 => 'Reset Content',
        304 => 'Not Modified',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        408 => '408 Request Timeout',
        422 => '422 Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code , // success or not?
        'message' => $message
        ));
}
