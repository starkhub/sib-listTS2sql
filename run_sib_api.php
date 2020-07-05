<?php
require_once(__DIR__ . '/vendor/autoload.php');

function sendToDb($liste_prospects, $liste_prospectsChauds, $list_lost, $list_clients){//Injection des résultats dans la BDD SQL
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $user = 'SQL DATABASE USER';
    $pass = 'SQL DATABASE PASSWORD';

    $p1 = $liste_prospects; //List Examples
    $p2 = $liste_prospectsChauds;
    $p3 = $list_lost;
    $p4 = $list_clients;
 
    $pdo = new PDO('mysql:host=localhost;dbname=sib_crm', $user, $pass);

    sleep(5);

    $sql = "INSERT INTO sib_crm.sib_lists_historic(prospect_list,prospectChaud_list,clientPerdu_list,clients_list,historic_date) VALUES ($p1, $p2, $p3, $p4, CAST(NOW() AS DATE))";

    $stmt = $pdo->prepare($sql);

    try {
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollback();
        throw $e;
    }
}

function getListsDetails()
{

    // Configure API key authorization: api-key
    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', 'PUT YOUR API KEY HERE');
    // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');
    // Configure API key authorization: partner-key
    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', 'PUT YOUR PARTNER KEY HERE');
    // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('partner-key', 'Bearer');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
        new GuzzleHttp\Client(),
        $config
    );
    $limit = 50; // int | Number of documents per page
    $offset = 0; // int | Index of the first document of the page

    try {
        $result = $apiInstance->getLists($limit, $offset);//Fetch all Sendinblue lists
        $obj = json_decode($result);//Decode the JSON returned result
        $liste_prospects = $obj->lists[26]->{'totalSubscribers'} + $obj->lists[26]->{'totalBlacklisted'};//Here you can select the list you want to track by reading the JSON
        $liste_prospectsChauds = $obj->lists[3]->{'totalSubscribers'} + $obj->lists[3]->{'totalBlacklisted'};
        $list_clients = $obj->lists[41]->{'totalSubscribers'} + $obj->lists[41]->{'totalBlacklisted'};
        $list_lost = $obj->lists[38]->{'totalSubscribers'} + $obj->lists[36]->{'totalBlacklisted'};

        sendToDb($liste_prospects, $liste_prospectsChauds, $list_lost, $list_clients);//Send all the lists total subscribers to SQL db

    } catch (Exception $e) {
        echo 'Exception when calling ContactsApi->getLists: ', $e->getMessage(), PHP_EOL;
    }
}

getListsDetails()//Ignition function;

?>