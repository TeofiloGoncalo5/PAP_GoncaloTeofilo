<?php
$numberOfDays = 5;
$startDate = date("d/m/Y");
$endDate = date("d/m/Y", strtotime("+$numberOfDays days"));

$start = str_replace("/", "%2F", $startDate);
$end = str_replace("/", "%2F", $endDate);
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://allscores.p.rapidapi.com/api/allscores/games-scores?startDate=" . $start . "&langId=1&sport=2&endDate=" . $end . "&timezone=America%2FChicago&onlyMajorGames=true",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: allscores.p.rapidapi.com",
        "X-RapidAPI-Key: ab7a71a2f4mshfb7fbd9e4cec934p193a77jsne9272113dde1"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo json_encode(["error" => "cURL Error: " . $err]);
} else {
    $response = json_decode($response, true);
    if (!$response) {
        echo json_encode(["error" => "Error: Failed to fetch data from API."]);
    } else {
        $event = [];
        $cont = 1;
        foreach ($response["games"] as $info) {
            $competitionId = isset($info["competitionId"]) ? $info["competitionDisplayName"] : null;
            $leagueName = $competitionId;
            $event[] = [
                "id" => $cont,
                "title" => $info["homeCompetitor"]["name"] . " X " . $info["awayCompetitor"]["name"],
                "start" => $info["startTime"],
                "league" => $leagueName,
            ];
            $cont++;
        }
        echo json_encode($event);
    }
}