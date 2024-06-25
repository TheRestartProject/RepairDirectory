<?php

namespace App\Console\Commands;

use App\Mail\BusinessDetailCheck;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class SendBusinessCheckMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'details:mailout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends emails to business owners to prompt for a check of details';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(EntityManagerInterface $em, BusinessRepository $businessRepository)
    {

        // Only send mails to published businesses that haven't opted out.

        $criteria = [
            [
                'field' => 'publishingStatus',
                'operator' => Operators::EQUAL,
                'value' => PublishingStatus::PUBLISHED
            ],
            [
                'field' => 'businessCheckMailOptout',
                'operator' => Operators::EQUAL,
                'value' => false
            ],           
        ];

        $businesses = $businessRepository->findBy($criteria);
        $businesses_mailed = 0;
        $businesses_no_email = 0;

        // Get configured reply-to address. In future, this can be over-ridden according to 
        // internal needs, eg for a specific contact for the region a business is in.
        // For now, we only use the one address.
        // NB This *must* be configured, currently.
        $reply_to = env('MAIL_BUSINESSCHECK_REPLYTO_MAIL');
        if (is_null($reply_to) || ! trim($reply_to)) {
            $this->error('No default reply-to email address configured. Please set MAIL_BUSINESSCHECK_REPLYTO_MAIL in your environment.');
            return Command::FAILURE;
        }

        foreach ($businesses as $business) {
            if ($business->getEmail()) {                
                Mail::to($business->getEmail())->send(new BusinessDetailCheck($business, [ $reply_to ], $em));
                $businesses_mailed++;
            } else {
                $businesses_no_email++;
            }
        }

        $this->info('Success! Total businesses: ' . count($businesses) . 
                     '. Mail queued: ' . $businesses_mailed . 
                     '. Without email: ' . $businesses_no_email . '.');

        return Command::SUCCESS;
    }
}
