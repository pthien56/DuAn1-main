<?php
class BaseController {
    
    protected function view($viewName, $data = [], $adminLayout = false) {
        extract($data);
        $basePath = dirname(__DIR__);
        if ($adminLayout) {
            require_once $basePath . "/views/admin/layouts/header.php";
            require_once $basePath . "/views/$viewName.php";
            require_once $basePath . "/views/admin/layouts/footer.php";
        } else {
            require_once $basePath . "/views/layouts/header.php";
            require_once $basePath . "/views/$viewName.php";
            require_once $basePath . "/views/layouts/footer.php";
        }
    }
    
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
    
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
?>

