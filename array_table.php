<?php
$tableHeaders = [
    "ID",
    "First Name",
    "Last Name",
    "Email",
    "Phone",
    "Created At",
    "Action"
];
echo "<table>";
echo "<tr>";
foreach ($tableHeaders as $header) {
    echo "<th>$header</th>";
}
echo "</tr>";
echo "</table>";
?> 
