<?php
/**
 * Doctrine CLI bootstrap for CodeIgniter
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 * @link    http://wildlyinaccurate.com/integrating-doctrine-2-with-codeigniter-2
 */

define('APPPATH', dirname(__FILE__) . '/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development');
define('VENDOR_PATH', APPPATH . '/../vendor/');

chdir(APPPATH);

include_once VENDOR_PATH . 'autoload.php';
require __DIR__ . '/libraries/Doctrine.php';

foreach ($GLOBALS as $helperSetCandidate) {
    if ($helperSetCandidate instanceof \Symfony\Component\Console\Helper\HelperSet) {
        $helperSet = $helperSetCandidate;
        break;
    }
}

$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
