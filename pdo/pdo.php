<?php
$pdo = new PDO('pgsql:host=localhost;port=80;dbname='project',
'user1', 'user1');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);