<?php
  include_once('../config.php');
  include_once('Database.php');
  global $env;

  if( $_GET['method'] !== 'search' ){
    getMovieDetails();
    return;
  }
  searchMovies();


  function getMovieDetails(){
    global $env;
    $url = 'https://api.themoviedb.org/3/movie/' . $_GET['movie'] . '?api_key=' . $env['API_KEY'];
    
    echo file_get_contents($url);
  }

  function searchMovies(){
    global $env;

    $query = '';
    if( isset($_GET['year']) ){
      $query = '&primary_release_year=' . urlencode($_GET['year']);
    }
    $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $env['API_KEY'] . '&language=en-US&query=' . urlencode($_GET['params']) . $query . '&page=1&include_adult=false';
    $movies = json_decode(file_get_contents($url));
    $moviesIterator = new ArrayIterator($movies->results);

    $results = [];
    foreach( $moviesIterator as $key => $movie ){
      if( count($results) == 10 ){
        break;
      }
      $tmp = [];
      $tmp['id'] = $movie->id;
      $tmp['title'] = $movie->original_title;
      $tmp['release_date'] = $movie->release_date;
      $tmp['poster'] = $movie->poster_path;
      $tmp['plot'] = $movie->overview;
      array_push( $results, $tmp );


    }
    //Save into mysql database
    saveBrowserAnalytics( $_SERVER['REMOTE_ADDR'], $_GET['params'] );
    echo json_encode($results);
  }

  function saveBrowserAnalytics($remoteIp, $searchTerms){
    global $env;

    try{
      $database = new Database( $env['db_host'], $env['db_user'], $env['db_pw'], $env['db_name']);
      $database->connect();
      $database->saveSearchAnalytics( $remoteIp, $searchTerms );
      
    }
    catch( Exception $e ){
      return $e;
    }



  }
?>
