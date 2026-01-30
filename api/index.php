<?php
session_start();
header('Content-Type: application/json');

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
    $file = __DIR__ . '/services/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

try {
    // Get controller and action from request
    $controller = $_GET['controller'] ?? $_POST['controller'] ?? null;
    $action = $_GET['action'] ?? $_POST['action'] ?? null;
    
    if (!$controller || !$action) {
        throw new Exception('Controller and action are required');
    }
    
    // Sanitize controller name
    $controllerName = ucfirst($controller) . 'Controller';
    
    if (!class_exists($controllerName)) {
        throw new Exception('Controller not found');
    }
    
    $controllerInstance = new $controllerName();
    
    if (!method_exists($controllerInstance, $action)) {
        throw new Exception('Action not found');
    }
    
    // Execute the action
    $result = $controllerInstance->$action();
    
    echo json_encode([
        'success' => true,
        'data' => $result
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
