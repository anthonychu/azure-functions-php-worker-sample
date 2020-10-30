<?php
    error_reporting(E_ERROR | E_PARSE);

    class Logger {
        public $messages = [];
        function information(string $msg) {
            array_push($this->messages, $msg);
        }
    }

    class FunctionContext {
        public $inputs = [];
        public $outputs;
        public $log;

        public function __construct() {
            $this->log = new Logger();
            $this->outputs = [ '_none_' => null ];
        }
    }

    $context = new FunctionContext();
    set_exception_handler(function ($exception) use ($context) {
        $context->log->information($exception);
        $response = [
            'Outputs' => NULL,
            'ReturnValue' => NULL,
            'Logs' => $context->log->messages
        ];
        echo(json_encode($response));
    });

    $requestUri = $_SERVER['REQUEST_URI'];
    $requestBody = file_get_contents('php://input');
    // $context->log->information($requestBody);
    // $context->log->information('headers: ' . json_encode(getallheaders()));
    $request = json_decode($requestBody, true);

    header("Content-type: application/json");

    require __DIR__ . $requestUri . '/index.php';

    $context->inputs = $request['Data'];
    $returnValue = run($context);
    if (is_null($returnValue)) {
        $returnValue = "";
    }

    $response = [
        'Outputs' => $context->outputs,
        'ReturnValue' => $returnValue,
        'Logs' => $context->log->messages
    ];

    header("Content-type: application/json");
    echo(json_encode($response));
?>