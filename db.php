<?php

//$dbHost = 'aws-0-ap-southeast-1.pooler.supabase.com';
//$dbUser = 'postgres.vcywfccwyqjngqubszid';
//$dbPassword = 'TmFiAkPIuDSWd40S';

$db = 'mylogin';
$username = 'root';
$password = '';
$host = 'localhost';
$conn = new mysqli($host, $username, $password, $db);

//$conn = pg_connect("host=$dbHost port=5432 dbname=postgres user=$dbUser password=$dbPassword sslmode=require");

if (!$conn) {
    exit('Database connection failed.');
}