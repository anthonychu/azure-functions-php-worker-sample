<?php
    function run(FunctionContext $context) {
        $queueItem = json_decode($context->inputs['item']);
        $context->log->information('Retrieved item from queue ' . $queueItem);

        // save queue item to blob storage
        $context->outputs['outputBlob'] = $queueItem;
    }
?>
