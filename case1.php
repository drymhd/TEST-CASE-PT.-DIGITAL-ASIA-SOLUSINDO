<?php

function mapData($dataGroup, $dataRaw) {
    $result = [];
    $branchTotals = [];
    $dateTotals = [];

    // Menghitung total grand_total untuk setiap cabang dan tanggal
    foreach ($dataRaw as $record) {
        $branch = $record['branch'];
        $date = $record['posting_date'];
        $grandTotal = $record['grand_total'];

        if (!isset($branchTotals[$branch])) {
            $branchTotals[$branch] = 0;
        }
        $branchTotals[$branch] += $grandTotal;

        if (!isset($dateTotals[$branch])) {
            $dateTotals[$branch] = [];
        }
        if (!isset($dateTotals[$branch][$date])) {
            $dateTotals[$branch][$date] = 0;
        }
        $dateTotals[$branch][$date] += $grandTotal;
    }

    // Menyusun data dengan indentasi
    foreach ($dataGroup as $group) {
        $branch = $group['branch'];
        $postingDate = $group['posting_date'];

        // Menambahkan data cabang dengan indentasi 0
        $foundBranch = false;
        foreach ($result as $res) {
            if(isset($res['branch'])){
                if ($res['branch'] === $branch && $res['indent'] === 0) {
                    $foundBranch = true;
                    break;
                }
            }
        }

        if (!$foundBranch) {
            $result[] = [
                'indent' => 0,
                'branch' => $branch,
                'grand_total' => $branchTotals[$branch]
            ];
        }

        // Menambahkan data tanggal dengan indentasi 1
        $result[] = [
            'indent' => 1,
            'posting_date' => $postingDate,
            'grand_total' => $dateTotals[$branch][$postingDate]
        ];

        // Menambahkan data raw dengan indentasi 2
        foreach ($dataRaw as $record) {
            if ($record['branch'] === $branch && $record['posting_date'] === $postingDate) {
                $result[] = [
                    'branch' => $record['branch'],
                    'posting_date' => $record['posting_date'],
                    'customer' => $record['customer'],
                    'grand_total' => $record['grand_total'],
                    'indent' => 2
                ];
            }
        }
    }

    return $result;
}

$dataGroup = [
    [ "branch" => "Surabaya", "posting_date" => "2024-01-01" ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-02" ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-03" ],
    [ "branch" => "Jakarta", "posting_date" => "2024-01-01" ],
    [ "branch" => "Jakarta", "posting_date" => "2024-01-03" ]
];

$dataRaw = [
    [ "branch" => "Surabaya", "posting_date" => "2024-01-01", "customer" => "CUST-001", "grand_total" => 100000 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-01", "customer" => "CUST-001", "grand_total" => 560000 ],
    [ "branch" => "Jakarta", "posting_date" => "2024-01-01", "customer" => "CUST-001", "grand_total" => 720000 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-02", "customer" => "CUST-001", "grand_total" => 340000 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-02", "customer" => "CUST-001", "grand_total" => 568000 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-02", "customer" => "CUST-001", "grand_total" => 142000 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-02", "customer" => "CUST-001", "grand_total" => 256000 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-03", "customer" => "CUST-001", "grand_total" => 234500 ],
    [ "branch" => "Surabaya", "posting_date" => "2024-01-03", "customer" => "CUST-001", "grand_total" => 345600 ],
    [ "branch" => "Jakarta", "posting_date" => "2024-01-03", "customer" => "CUST-001", "grand_total" => 125000 ],
    [ "branch" => "Jakarta", "posting_date" => "2024-01-03", "customer" => "CUST-001", "grand_total" => 70000 ],
    [ "branch" => "Jakarta", "posting_date" => "2024-01-03", "customer" => "CUST-001", "grand_total" => 86000 ]
];

$result = mapData($dataGroup, $dataRaw);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case 1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <table border="1" class="table">
        <thead>
            <tr>
                <th>Output</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <td><?php print_r($row) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    
</body>
</html>