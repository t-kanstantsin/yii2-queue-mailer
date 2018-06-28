<?php

namespace YarCode\Yii2\QueueMailer\Proxy;

use YarCode\Yii2\QueueMailer\Jobs\SendMessageJob;
use YarCode\Yii2\QueueMailer\Jobs\SendMultipleMessagesJob;
use yii\base\BaseObject;
use yii\di\Instance;
use yii\mail\MessageInterface;
use yii\queue\Queue;

/**
 * Class QueueProxy
 */
class QueueProxy extends BaseObject implements IProxy
{
    /** @var string ID of mailer component in app */
    public $mailer = 'mailer';
    /** @var string ID of queue component in app */
    public $queue = 'queue';

    /**
     * id of a job message
     * @see \yii\queue\Queue::push()
     * @var string|null
     */
    protected $lastJobId;

    /**
     * @return Queue
     * @throws \yii\base\InvalidConfigException
     */
    public function getQueue(): Queue
    {
        if (\is_callable($this->queue)) {
            $this->queue = \call_user_func($this->queue);
        }

        return $this->queue = Instance::ensure($this->queue, Queue::class);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function push(MessageInterface $message): bool
    {
        $this->lastJobId = $this->getQueue()->push(\Yii::createObject([
            'class' => SendMessageJob::class,
            'message' => $message,
            'mailer' => $this->mailer,
        ]));

        return $this->lastJobId !== NULL;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function pushMultiple(array $messages): int
    {
        $this->lastJobId = $this->getQueue()->push(\Yii::createObject([
            'class' => SendMultipleMessagesJob::class,
            'messages' => $messages,
            'mailer' => $this->mailer,
        ]));

        return $this->lastJobId !== null ? \count($messages) : 0;
    }

    /**
     * @return null|string
     */
    public function getLastJobId(): ?string
    {
        return $this->lastJobId;
    }
}