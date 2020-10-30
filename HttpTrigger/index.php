<?php
    function run(FunctionContext $context) {
        $req = $context->inputs['req'];
        //$context->log->information(json_encode($req));
        $context->log->information('Http trigger invoked');

        $query = json_decode($req['Query'], true);

        if (array_key_exists('name', $query)) {
            $name = $query['name'];
            $message = 'Hello ' . $query['name'] . '!';
        } else {
            $name = 'EMPTY';
            $message = 'Please pass a name in the query string';
        }

        $context->outputs['outputQueueItem'] = $name;

        return [
            'body' => $message,
            'headers' => [
                'Content-type' => 'text/plain'
            ]
        ];
    }
?>
