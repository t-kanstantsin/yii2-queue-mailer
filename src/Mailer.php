<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace YarCode\Yii2\QueueMailer;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\mail\BaseMailer;
use yii\mail\MailerInterface;

/**
 * Class Mailer
 *
 * @property Proxy\IProxy $proxy
 */
class Mailer extends Component implements MailerInterface
{
    /** @var MailerInterface */
    protected $syncMailer;
    /**
     * @var string|Proxy\IProxy
     */
    protected $proxy = [
        'class' => Proxy\QueueProxy::class,
        'mailer' => 'mailer',
    ];

    /**
     * @return Proxy\IProxy
     * @throws InvalidConfigException
     */
    public function getProxy(): Proxy\IProxy
    {
        if (\is_callable($this->proxy)) {
            $this->proxy = \call_user_func($this->proxy);
        }

        return $this->proxy = Instance::ensure($this->proxy, Proxy\IProxy::class);
    }

    /**
     * @param mixed $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return MailerInterface
     * @throws InvalidConfigException
     */
    public function getSyncMailer(): MailerInterface
    {
        if (\is_callable($this->syncMailer)) {
            $this->syncMailer = \call_user_func($this->syncMailer);
        }

        return $this->syncMailer = Instance::ensure($this->syncMailer, MailerInterface::class);
    }

    /**
     * @param mixed $syncMailer
     */
    public function setSyncMailer($syncMailer)
    {
        $this->syncMailer = $syncMailer;
    }

    /**
     * @inheritdoc
     * @see MailerInterface::compose()
     * @throws InvalidConfigException
     */
    public function compose($view = null, array $params = [])
    {
        return $this->getSyncMailer()->compose($view, $params);
    }

    /**
     * @inheritdoc
     * @see MailerInterface::send()
     *
     * @throws InvalidConfigException
     */
    public function send($message)
    {
        return $this->getProxy()->push($message);
    }

    /**
     * @inheritdoc
     * @see MailerInterface::sendMultiple()
     * @see BaseMailer::sendMultiple()
     *
     * @throws InvalidConfigException
     */
    public function sendMultiple(array $messages)
    {
        return $this->getProxy()->pushMultiple($messages);
    }
}