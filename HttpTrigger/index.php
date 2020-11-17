<?php
use Azserverless\Context\FunctionContext;

    function run(FunctionContext $context) {

        $req = $context->inputs['req'];

        $context->log->info('Http trigger invoked');

        $query = $req['Query'];

        if (array_key_exists('name', $query)) {
            $name = $query['name'];
            $message = 'Hello ' . $query['name'] . '!';
        } else {
            $name = 'EMPTY';
            $message = 'Please pass a name in the query string';
        }

        $context->outputs['outputQueueItem'] = json_encode($name);
        $context->log->info(sprintf('Adding queue item: %s', $name));

        return [
            'body' => $message,
            'headers' => [
                'Content-type' => 'text/plain'
            ]
        ];
    }
?>
