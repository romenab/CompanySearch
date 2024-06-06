<?php
require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

while (true) {
    $company = trim(strtolower(readline("Enter company name to search: ")));
    if (empty($company)) {
        echo "Please enter a valid company name." . PHP_EOL;
        continue;
    }
    $url = "https://data.gov.lv/dati/lv/api/3/action/datastore_search?q=" .
        $company . "&resource_id=25e80bf3-f107-4ab4-89ef-251b5b9374e9";
    
    $getContents = json_decode(file_get_contents($url));
    if ($getContents === null) {
        echo "Error" . PHP_EOL;
        continue;
    }

    $output = new ConsoleOutput();
    $table = new Table($output);

    $table->setHeaders(['User Search', 'Company Name']);

    foreach ($getContents->result->records as $foundCompany) {
        $table->addRow([
            $company,
            $foundCompany->name
        ]);
    }
    $table->render();
    $searchMore = readline("Want to search another company?(y/n): ");
    if ($searchMore == "n") {
        exit;
    }
}



