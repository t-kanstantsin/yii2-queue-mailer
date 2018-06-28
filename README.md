# Queue mailer decorator for Yii2 framework
Send your emails in the background using Yii2 queues.

[![Latest Stable Version](https://poser.pugx.org/t-kanstantsin/yii2-queue-mailer/v/stable)](https://packagist.org/packages/t-kanstantsin/yii2-queue-mailer)
[![Total Downloads](https://poser.pugx.org/t-kanstantsin/yii2-queue-mailer/downloads)](https://packagist.org/packages/t-kanstantsin/yii2-queue-mailer)
[![License](https://poser.pugx.org/t-kanstantsin/yii2-queue-mailer/license)](https://packagist.org/packages/t-kanstantsin/yii2-queue-mailer)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yarcode/yii2-queue-mailer
```

or add

```json
"yarcode/yii2-queue-mailer": "*"
```

## Usage

Configure `queue` component of your application.
You can find the details here: https://www.yiiframework.com/extension/yiisoft/yii2-queue

Configure `YarCode\Yii2\QueueMailer\Mailer` as your primary mailer.

```
  'mailer' => [
      'class' => \YarCode\Yii2\QueueMailer\Mailer::class,
      'syncMailer' => [
          'class' => \yii\swiftmailer\Mailer::class,
          'useFileTransport' => true,
      ],
  ],
```

Now you can send your emails as usual.

```
$message = \Yii::$app->mailer->compose()
  ->setSubject('test subject')
  ->setFrom('test@example.org')
  ->setHtmlBody('test body')
  ->setTo('user@example.org');

\Yii::$app->mailer->send($message);
```

You can also get a background job ID of the last `send()` or `sendMultiple()` call.
```
$jobId = \Yii::$app->mailer->getLastJobId();
```
 
## Licence ##

MIT
    
## Links ##

* [GitHub repository](https://github.com/yarcode/yii2-queue-mailer)
* [Composer package](https://packagist.org/packages/yarcode/yii2-queue-mailer)