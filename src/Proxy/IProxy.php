<?php

namespace YarCode\Yii2\QueueMailer\Proxy;

use yii\mail\MessageInterface;

/**
 * Interface IProxy
 */
interface IProxy
{
    /**
     * @param MessageInterface $message
     * @return bool whether the message has been sent via proxy successfully.
     */
    public function push(MessageInterface $message): bool;

    /**
     * @param MessageInterface[] $messages
     * @return int number of messages that are successfully sent.
     */
    public function pushMultiple(array $messages): int;
}