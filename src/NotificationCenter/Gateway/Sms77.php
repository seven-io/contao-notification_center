<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

namespace Sms77\ContaoNotificationCenterBundle\NotificationCenter\Gateway;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\System;
use NotificationCenter\Gateway\Base;
use NotificationCenter\Gateway\GatewayInterface;
use NotificationCenter\MessageDraft\MessageDraftFactoryInterface;
use NotificationCenter\Model\Gateway as GatewayModel;
use NotificationCenter\Model\Language as LanguageModel;
use NotificationCenter\Model\Message as MessageModel;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Sms77\ContaoNotificationCenterBundle\NotificationCenter\MessageDraft\Sms77SmsDraft;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Sms77 extends Base implements GatewayInterface, MessageDraftFactoryInterface {
    protected $objModel;
    protected LoggerInterface $logger;
    protected ?string $apiKey = null;

    public function __construct(GatewayModel $model) {
        parent::__construct($model);

        $container = System::getContainer();
        /** @var LoggerInterface $logger */
        $logger = $container->get('monolog.logger.contao');
        $this->logger = $logger;
        if ($container->hasParameter('sms77.api_key'))
            $this->apiKey = $container->getParameter('sms77.api_key');
    }

    public function createDraft(MessageModel $objMessage, array $arrTokens, $strLanguage = '') {
        if ('' === $strLanguage) $strLanguage = (string)$GLOBALS['TL_LANGUAGE'];

        $languageModel = LanguageModel::findByMessageAndLanguageOrFallback($objMessage,
            $strLanguage);

        if (null === $languageModel) {
            $this->logger->log(LogLevel::ERROR,
                sprintf('No message/fallback found for message "%s" and language "%s".',
                    $objMessage->id, $strLanguage),
                ['contao' => new ContaoContext(__METHOD__, TL_ERROR)]
            );

            return null;
        }

        return new Sms77SmsDraft($objMessage, $languageModel, $arrTokens);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function send(MessageModel $message, array $tokens, $language = '') {
        $apiKey = $this->getApiKey();
        if ('' === $apiKey) return false;

        $draft = $this->createDraft($message, $tokens, $language);
        if (null === $draft) return false;

        $client = HttpClient::createForBaseUri('https://gateway.sms77.io/api/',
            [
                // 'auth_bearer' => $apiKey,
            ]
        );

        $this->logger->log(LogLevel::DEBUG,
            sprintf('sms77 API Key: %s', $apiKey), []);

        $success = true;
        foreach ($draft->getRecipients() as $recipient) {
            $response = $client->request('POST', 'sms', [
                    'headers' => [
                        'X-Api-Key' => $apiKey,
                    ],
                    'json' => [
                        'from' => $draft->getFrom(),
                        'json' => 1,
                        'text' => $draft->getText(),
                        'to' => $recipient,
                    ],
                ]
            );

            $content = $response->toArray(false);
            if (100 !== (int)$content['success']) {
                $success = false;

                $this->logger->log(LogLevel::ERROR,
                    sprintf('Error sending SMS: %s', $content['success']),
                    ['contao' => new ContaoContext(__METHOD__, TL_ERROR)]
                );
            }
        }

        return $success;
    }

    protected function getApiKey(): string {
        return $this->apiKey ?: $this->objModel->sms77_apiKey;
    }
}
