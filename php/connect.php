<?php
/* at the top of 'check.php' */
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* 
        Up to you which header to send, some prefer 404 even if 
        the files does exist for security
    */
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

    /* choose the appropriate page to redirect users */
    die( header( 'location: ../' ) );
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_raion';

$connect = mysqli_connect($host,$user,$pass,$db);

if(!$connect) {
    echo '<code>koneksi ke database gagal</code>';
}
?>
