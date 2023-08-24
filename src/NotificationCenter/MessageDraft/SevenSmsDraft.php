<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

namespace Seven\ContaoNotificationCenterBundle\NotificationCenter\MessageDraft;

use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\StringUtil as ContaoStringUtil;
use Contao\System;
use Haste\Util\StringUtil as HasteStringUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use NotificationCenter\MessageDraft\MessageDraftInterface;
use NotificationCenter\Model\Language as LanguageModel;
use NotificationCenter\Model\Message as MessageModel;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class SevenSmsDraft implements MessageDraftInterface {
    protected LanguageModel $languageModel;
    protected LoggerInterface $logger;
    protected MessageModel $messageModel;
    protected array $tokens = [];

    public function __construct(
        MessageModel $messageModel,
        LanguageModel $languageModel,
        array $tokens
    ) {
        $this->messageModel = $messageModel;
        $this->languageModel = $languageModel;
        $this->tokens = $tokens;

        /** @var LoggerInterface $logger */
        $logger = System::getContainer()->get('monolog.logger.contao');
        $this->logger = $logger;
    }

    public function getFrom(): ?string {
        return HasteStringUtil::recursiveReplaceTokensAndTags(
            $this->languageModel->seven_sender_name,
            $this->tokens,
            HasteStringUtil::NO_TAGS | HasteStringUtil::NO_EMAILS
            | HasteStringUtil::NO_BREAKS
        ) ?: null;
    }

    public function getRecipients(): array {
        // Replaces tokens first so that tokens can contain a list of recipients.
        $recipients = HasteStringUtil::recursiveReplaceTokensAndTags(
            $this->languageModel->seven_recipient_number,
            $this->tokens,
            HasteStringUtil::NO_TAGS | HasteStringUtil::NO_EMAILS
            | HasteStringUtil::NO_BREAKS
        );

        return array_filter(
            array_map(
                function (string $phone) {
                    $phone = HasteStringUtil::recursiveReplaceTokensAndTags($phone,
                        $this->tokens, HasteStringUtil::NO_TAGS
                        | HasteStringUtil::NO_EMAILS | HasteStringUtil::NO_BREAKS
                    );

                    try {
                        return $this->normalizePhoneNumber($phone);
                    } catch (NumberParseException $e) {
                        $this->logger->log(LogLevel::ERROR, sprintf(
                            'Skipping recipient \'%s\' due to invalid number %s',
                            $phone, $e->getMessage()),
                            ['contao' => new ContaoContext(__METHOD__, TL_ERROR)]
                        );
                    }

                    return null;
                },
                ContaoStringUtil::trimsplit(',', $recipients)
            )
        );
    }

    public function getText(): string {
        return Controller::convertRelativeUrls(
            HasteStringUtil::recursiveReplaceTokensAndTags(
                $this->languageModel->seven_text, $this->tokens, HasteStringUtil::NO_TAGS
            ), '', true);
    }

    public function getTokens() {
        return $this->tokens;
    }

    public function getMessage() {
        return $this->messageModel;
    }

    public function getLanguage() {
        return $this->languageModel->language;
    }

    /**
     * Normalize a phone number and return in E.164 format.
     * When a phone number is present in a local format, use a fallback region (that may
     * be defined in the language model, or inherited from the language).
     * @throws NumberParseException
     */
    protected function normalizePhoneNumber(string $phone): string {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();

        // We have to find a default country code as we can not make sure to get a internationalized phone number
        /*        $defaultRegion = HasteStringUtil::recursiveReplaceTokensAndTags(
                    $this->languageModel->sms_recipients_region, $this->tokens,
                    HasteStringUtil::NO_TAGS | HasteStringUtil::NO_EMAILS | HasteStringUtil::NO_BREAKS
                ) ?: $this->languageModel->language;*/
        $defaultRegion = $this->languageModel->language;

        $phoneNumber = $phoneNumberUtil->parse($phone, strtoupper($defaultRegion));

        return $phoneNumberUtil->format($phoneNumber, PhoneNumberFormat::E164);
    }
}
