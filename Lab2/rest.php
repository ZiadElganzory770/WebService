<?php
//
require_once 'vendor/autoload.php';

$urlParts = explode('/', $_SERVER['REQUEST_URI']);
$resource = $urlParts[2];
$resourceId = (isset($urlParts[3]) && is_numeric($urlParts[3])) ? (int) $urlParts[3] : 0;

/**
 * 1- Define METHOD
 * 2- Define RESOURCE
 * 3- Define Resource_ID
 */
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data = handleGet($resource, $resourceId);
        break;
    case 'POST':
        $data = handlePost($resource);
        break;
    default:
        http_response_code(405);
        return ["Error" => "Method not allowed"];
        break;
}


header('Content-Type: application/json');

if (!empty($data)) {
    echo json_encode($data);
} else {
    print_r("Test");
}

/**
 * 
 * Get with no item (item id = any id found in database) => item
 * Get with item => get only single item
 * 
 * @param type $resource
 * @param type $resourceId
 * @return type
 */
function handleGet($resource, $resourceId)
{
    $conn = new MySQLHandler;
    if($resource == "item"){
        if($conn->connect()){
            if($resourceId == 0 ){
                $items = $conn->get_data(array("id","product_name"));
                return ["msg" => "success", "items" => $items];
            } else {
                $item = $conn->get_record_by_id($resourceId,"id");
                if(!empty($item) && count($item) > 0){
                    return ["msg" => "success", "item" => $item];
                } else {
                    return ["Error" => "Fail : Item not exist"];
                }
            }
        } else {
            http_response_code(500);
            return ["Error" => "Fail : resource not exist"];
        }
    }
}

/**
 * 
 * Post with add
 * Post by form that set in form for item
 * 
 * @param type $resource
 *
 * @return type json message 
 */

function handlePost($resource)
{

    $conn = new MySQLHandler;

    if ($resource == "item") {
        if ($conn->connect()) {

            $item = new Items();
            try {
                $item->id = $_POST["id"];
                $item->product_name = $_POST["product_name"];
                $item->PRODUCT_code = $_POST["PRODUCT_code"];
                $item->list_price = $_POST["list_price"];


                $item->save();
                return ["msg" => "Product added sucessfully "];
            } catch (\Exception $ex) {
                return ["msg" => "fail: " . $ex->getMessage()];
            }
        } else {
            http_response_code(500);
            return ["Error" => "Internal server error"];
        }
    } else {
        http_response_code(404);
        return ["Error" => "Resource does not exist"];
    }
}
