<!DOCTYPE html>
<html>
<head>
<title> </title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$GLOBALS['summID'];

$curl = curl_init();
$key = 'cbd91b2b-8963-4d99-8018-8b2c4fc48cca'; //Api key


$summonerName = $_GET["summName"];
$region = na;  //Give menu option

$summonerURL = 'https://prod.api.pvp.net/api/lol/na/v1.3/summoner/by-name/' . $summonerName . '?api_key=' . $key; //Access basic information
$urlApi = 'https://prod.api.pvp.net/api/lol/' . $region . '/'; 	//Beginning of the url for the api

//Opens up the basic summoner information
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $summonerURL
));

//Checks for an error
if(!curl_exec($curl)){
    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
}

//Obtains the result
$result	= curl_exec($curl);

//Checks for error (might want to update this to find out what the specific errors are)
if(is_string(json_decode($result,true)))
{
	die('Error: Summoner Not Found');
}

//Decodes the json value that is returned and looks for summoner id
$summoner = json_decode($result, true);
$summID = $summoner[strtolower($summonerName)]['id'];

//Last 	three APIs for summoner
$api = array('v1.3/stats/by-summoner/' . $summID . '/summary?season=SEASON4&api_key=' . $key, //Basic Game Statistics
'v1.3/stats/by-summoner/' . $summID . '/ranked?season=SEASON4&api_key=' . $key, //Basic Ranked Game Statistics
'v1.3/game/by-summoner/' .$summID . '/recent?api_key=' . $key); //Recent Game Showing

//Access for the last three sites
$summaryStats = json_decode(file_get_contents($urlApi . $api[0], true), true);
$summaryRanked = json_decode(file_get_contents($urlApi . $api[1], true), true);
$recentGames = json_decode(file_get_contents($urlApi . $api[2], true), true);
$playsRanked = true;

//Detects if the player plays ranked
if(is_string(summaryRanked))
{
	$playsRanked = false;
}

//echo $summaryStats['playerStatSummaries'][0]['aggregatedStats']['totalChampionKills']; //Calling the data in summary statisitcs

curl_close($curl);
?></p>
</body>
</html>