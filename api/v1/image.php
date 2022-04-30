<?php
include_once('access.php');

# Get info on a user, product, or service with that base64 encoded uuid
function info($id = '', $type = '')
{
    $results = get_image_id_type($id, $type);
    return $results;
}

if (count(get_included_files()) === 4)
{
    header("Content-Type: application/jpeg");
    # If the page uses the get method load the information from the query string
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        parse_str($_SERVER['QUERY_STRING'], $params);
    }
    else # If the page is loaded with POST or PATCH
    {
        $params = $_POST;
    }

    # Get information from search
    $id = $params['id'];
    $type = $params['type'];
    echo get_image_id_type($id, $type);
}
?>
