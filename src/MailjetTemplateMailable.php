<?php

declare(strict_types=1);

namespace Windy\Mailjet;

use Illuminate\Mail\Mailable;
use Swift_Message;
use function json_encode;

/**
 * Base mailable for Mailjet template-based emails.
 */
class MailjetTemplateMailable extends Mailable
{
    /** @var string|int The Mailjet template id. */
    protected $templateId;

    /**
     * Hijack the Laravel renderer since we do not need to render anything (that is Mailjet's job).
     *
     * @see Mailable::buildView()
     *
     * @return mixed[]
     */
    protected function buildView(): array
    {
        return [null, null, 'raw'];
    }

    /**
     * Register Mailjet's headers.
     */
    public function build(): void
    {
        $this->withSwiftMessage(function (Swift_Message $message): void {
            // Enable template language
            $message->getHeaders()->addTextHeader('X-MJ-TemplateID', $this->templateId);
            $message->getHeaders()->addTextHeader('X-MJ-TemplateLanguage', true);

            // Encode email variables
            $mailjetVariables = json_encode($this->buildViewData());
            $message->getHeaders()->addTextHeader('X-MJ-Vars', $mailjetVariables);
        });
    }
}
