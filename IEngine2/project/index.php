<?php

// load in IEngine
require_once '../IEngine2/IEngine.php';

// have Engine on standby
$engine = IEngine::getInstance ();
global $engine;

// load in database connection
$engine->usingPackage ( 'DBaseConnect' );

// load in the file database Manager
$engine->usingPackage ( 'FileDBase' );

// load in all function files
IEngine::loadAll ( "../IEngine2/library" );

// Load all controllers
IEngine::loadAll ( "application/controllers" );

// init globals
iGlobal::init ();

// init FDBase
/*$fdb = FDBase::getInstance ( $host, $username, $password, $databasename );
$fdb->makeDB ();

 * creating and inserting data into dbase table 
 * $fdb->openDB();
 * $fdb->makeTable($tableName);
 * $fdb->setFields($tableName,array('id','username','password'));
 * $fdb->insert($tableName,array($id,$username,$password));
 * $fdb->get($tableName,'id', 0); $results = $fdb->results();
 */

// set page information
$pages = pageControl::getInstance ();

// set in Routers

$route = new Routes ( $pages );

// set home page
$pages->setHomePage ( "index.php", "Home" );
$pages->set404 ( "404.php", "404" );

/**
 * *********add in pages**************
 */

/*
 * $pages->addPage("Login", "login.php");
 * $pages->addPage("Register","register.php");
 */

/**
 * *********************************
 */
// scan for pages
$route->scan ( "Home", "404" );

// add in globals
iGlobal::AddGlobal ( "IEngine", $engine );
iGlobal::AddGlobal ( "Router", $route );
iGlobal::AddGlobal ( "FDBase", $fdb );

/**
 * ******************Display Page*********
 */


                                  
// load page
$route->routeTo ();


?>





