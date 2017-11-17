<?php

if (isset($_GET['query']) && $_GET['maxNb']) {

  require_once 'vendor/autoload.php';
  $DEVELOPER_KEY = get_option( 'yt_to_posts_ck', '' );




  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);


  $youtube = new Google_Service_YouTube($client);
  $queryType = get_option( 'yt_to_posts_query_type', '' );

  $lastIdDate = $_GET['lastIdDate'];



  $response;

  if($queryType === 'free'){
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'type' => 'video',
      'q' => $_GET['query'],
      'maxResults' => $_GET['maxNb'],
      'order' => 'date',
      'part' => 'snippet',
      'publishedBefore' => $lastIdDate

    ));
    foreach ($searchResponse['items'] as $searchResult) {

          $newResult;
          $newResult['id'] = $searchResult['id']['videoId'];
          $newResult['title'] = $searchResult['snippet']['title'];
          $newResult['description'] = $searchResult['snippet']['description'];
          $newResult['thumb_url'] = $searchResult['snippet']['thumbnails']['high']['url'];

          $newResult['media_url'] = 'https://www.youtube.com/watch?v='.$newResult['id'];
          $newResult['embed_url'] = '//www.youtube.com/embed/'.$newResult['id'];

          $newResult['tags'] = $searchResult;
          $newResult['date'] = $searchResult['snippet']['publishedAt'];
          $newResult['channel_title'] = $searchResult['snippet']['channelTitle'];
          $response['items'][] = $newResult;

    }


  }
  else if ($queryType === 'channel'){
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'channelId' => $_GET['query'],
      'maxResults' => $_GET['maxNb'],
      'order' => 'date',
      'part' => 'snippet,id',
    ));
    foreach ($searchResponse['items'] as $searchResult) {

          $newResult;
          $newResult['id'] = $searchResult['id']['videoId'];
          $newResult['title'] = $searchResult['snippet']['title'];
          $newResult['description'] = $searchResult['snippet']['description'];
          $newResult['thumb_url'] = $searchResult['snippet']['thumbnails']['high']['url'];

          $newResult['media_url'] = 'https://www.youtube.com/watch?v='.$newResult['id'];
          $newResult['embed_url'] = '//www.youtube.com/embed/'.$newResult['id'];

          $newResult['tags'] = $searchResult;
          $newResult['date'] = $searchResult['snippet']['publishedAt'];
          $newResult['channel_title'] = $searchResult['snippet']['channelTitle'];
          $response['items'][] = $newResult;

    }
  }
  else if ($queryType === 'playlist'){
    if($_GET['nextPageToken']){
      $args = array(
        'playlistId' => $_GET['query'],
        'maxResults' => $_GET['maxNb'],
        'part' => 'snippet,contentDetails',
        'pageToken' => $_GET['nextPageToken']
      );
    }
    else {
      $args = array(
        'playlistId' => $_GET['query'],
        'part' => 'snippet,contentDetails',
        'maxResults' => $_GET['maxNb']
      );
    }

    $searchResponse = $youtube->playlistItems->listPlaylistItems('snippet', $args);
    $response['nextPageToken'] = $searchResponse['nextPageToken'];
    foreach ($searchResponse['items'] as $searchResult) {

          $newResult;
          $newResult['kind'] = $searchResult['kind'];

          $newResult['title'] = $searchResult['snippet']['title'];
          $newResult['description'] = $searchResult['snippet']['description'];
          $newResult['thumb_url'] = $searchResult['snippet']['thumbnails']['high']['url'];

          $pattern = '/\/vi\/(.*)\//';
          preg_match($pattern, $newResult['thumb_url'], $matches, PREG_OFFSET_CAPTURE, 3);
          $newResult['id'] = $matches[1][0];
          $newResult['media_url'] = 'https://www.youtube.com/watch?v='.$newResult['id'];
          $newResult['embed_url'] = '//www.youtube.com/embed/'.$newResult['id'];

          $newResult['tags'] = $searchResult;
          $newResult['date'] = $searchResult['snippet']['publishedAt'];
          $newResult['channel_title'] = $searchResult['snippet']['channelTitle'];
          $response["items"][] = $newResult;

    }
  }
  try {


    $response = json_encode($response);
    echo $response;



  } catch (Google_ServiceException $e) {
    echo 'Google_ServiceException';
  } catch (Google_Exception $e) {
    echo 'Google_Exception';
  }
}

?>
