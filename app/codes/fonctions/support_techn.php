<?php 
$host = 'localhost';
$user = 'root'; 
$pass = 'devpro';
$db = 'sbdata'; 
$chemin='C:/wamp64/www/smartbiz/backup/';
$filename = 'database_backup_'.date('Y-m-d').'.sql.gz'; 
// Create a new MySQL PDO connection.
$pdo = new PDO('mysql:host=host; dbname=db, user,pass'); 
// Execute the mysqldump command to backup the database. 
$command = "mysqldump -hhost -u user -ppass db | gzip >$chemin.$filename"; 
if(file_exists($chemin.$filename)){
    echo "backup ok";
}else{
    echo "backup ko";
}
system($command); ?>