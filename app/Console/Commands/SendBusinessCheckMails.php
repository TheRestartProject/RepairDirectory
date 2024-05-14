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

        foreach ($businesses as $business) {
            if ($business->getEmail()) {
                $reply_to = env('MAIL_BUSINESSCHECK_REPLYTO_MAIL');
                Mail::to($business->getEmail())->send(new BusinessDetailCheck($business, [ $reply_to ], $em));
            }
        }

        return Command::SUCCESS;
    }
}
