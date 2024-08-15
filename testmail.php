<?php
echo 'Testing smtp.gmail.com:587: ';
$handle = stream_socket_client('smtp.gmail.com:587', $errno, $errstr, 5);

if (!$handle) {
echo "ERROR: $errno - $errstr<br />\n";
} else {
echo 'successfull connected';
}

echo '<br><br>Testing smtp.gmail.com:465: ';
$handle = stream_socket_client('smtp.gmail.com:465', $errno, $errstr, 5);

if (!$handle) {
echo "ERROR: $errno - $errstr<br />\n";
} else {
echo 'successfull connected';
}

echo '<br><br>Testing smtp.office365.com:587: ';
$handle = stream_socket_client('smtp.office365.com:587', $errno, $errstr, 5);

if (!$handle) {
echo "ERROR: $errno - $errstr<br />\n";
} else {
echo 'successfull connected';
}
?>