<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class WebsiteValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class WebsiteValidator implements Validator
{

    /**
     * Throw a ValidationException if the website is too short, too long, or doesn't include a '.'
     *
     * @param string $website The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate($website)
    {
        if (strlen($website) < 5 || strlen($website) > 100) {
            throw new ValidationException('Website invalid: must be between 5 and 100 characters long');
        }

        if (strpos($website, '.') === false) {
            throw new ValidationException('Website invalid: must include a domain');
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $website);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Time out fairly fast.
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);

        // Add some plausible headers - some sites require this.
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'accept-encoding: gzip, deflate, br',
            'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
            'cache-control: no-cache',
            'pragma: no-cache',
            'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="90", "Google Chrome";v="90"',
            'sec-ch-ua-mobile: ?0',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: none',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36']);

        // A small number of sites use unusual certificate authorities which we cannot verify.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, true);

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status !== 200 && $status !== 302) {
            if ($status === 301) {
                if (preg_match('~Location: (.*)~i', $response, $match)) {
                    $location = trim($match[1]);
                    throw new ValidationException("$website redirected to $location");
                }
            }

            throw new ValidationException("$website is invalid (fetch returned $status)");
        }
    }
}
