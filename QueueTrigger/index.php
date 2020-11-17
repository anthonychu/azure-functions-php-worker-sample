<?php
use Azserverless\Context\FunctionContext;
    function run(FunctionContext $context) {
        $queueItem = $context->inputs['item'];
        $context->log->info('Retrieved item from queue ' . json_decode($queueItem));

        // save queue item to blob storage
        $context->outputs['outputBlob'] = $queueItem;
    }
?>
