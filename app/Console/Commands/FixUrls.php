<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use Doctrine\ORM\EntityManagerInterface;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class FixUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix business URLs to be in correct format';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(EntityManagerInterface $em, BusinessRepository $businessRepository)
    {
        $businesses = $businessRepository->findAll(null, TRUE);

        foreach ($businesses as $business) {
            $url = $business->getWebsite();
            $oldurl = $url;

            if ($url) {
                if (strpos($url, 'https://') === FALSE) {
                    $url = "https://$url";
                }

                if ($url !== $oldurl) {
                    $this->line("#" . $business->getUid() . " $oldurl => $url");
                    $business->setWebsite($url);
                    $em->flush();
                }
            }
        }
    }
}
