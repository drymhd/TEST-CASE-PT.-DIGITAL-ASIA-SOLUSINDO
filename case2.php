<?php

function process_data($data_group, $data_x, $data_y) {
    // Mengonversi data_x dan data_y menjadi array asosiatif untuk pencarian cepat
    $visitors_data = [];
    $transactions_data = [];
    

    foreach ($data_x as $data) {
        $key = $data['branch'] . '_' . $data['posting_date'];
        $visitors_data[$key] = $data['visitors'];
    }

    foreach ($data_y as $data) {
        $key = $data['branch'] . '_' . $data['posting_date'];
        $transactions_data[$key] = $data['total_transactions'];
    }

    $result = [];

    foreach ($data_group as $group) {
        $branch = $group['branch'];
        $branch_data = ["branch" => $branch];

        foreach ($visitors_data as $key => $visitors) {
            if (strpos($key, $branch . '_') === 0) {
                $date_key = substr($key, strlen($branch) + 1);
                $total_transactions = isset($transactions_data[$key]) ? $transactions_data[$key] : 0;
                $ratio = $visitors == 0 ? 0 : round($total_transactions / $visitors, 2);
                $branch_data[$date_key] = $ratio;
            }
        }

        $result[] = $branch_data;
    }

    return $result;
}

// Data input
$data_group = [
    ["branch" => "Surabaya"],
    ["branch" => "Jakarta"]
];
$data_x = [
    ["branch" => "Surabaya", "posting_date" => "2024-01-01", "visitors" => 100],
    ["branch" => "Surabaya", "posting_date" => "2024-01-02", "visitors" => 80],
    ["branch" => "Surabaya", "posting_date" => "2024-01-03", "visitors" => 25],
    ["branch" => "Surabaya", "posting_date" => "2024-01-04", "visitors" => 36],
    ["branch" => "Surabaya", "posting_date" => "2024-01-05", "visitors" => 48],
    ["branch" => "Surabaya", "posting_date" => "2024-01-06", "visitors" => 24],
    ["branch" => "Surabaya", "posting_date" => "2024-01-07", "visitors" => 35],
    ["branch" => "Jakarta", "posting_date" => "2024-01-01", "visitors" => 200],
    ["branch" => "Jakarta", "posting_date" => "2024-01-02", "visitors" => 235],
    ["branch" => "Jakarta", "posting_date" => "2024-01-03", "visitors" => 125],
    ["branch" => "Jakarta", "posting_date" => "2024-01-04", "visitors" => 115],
    ["branch" => "Jakarta", "posting_date" => "2024-01-05", "visitors" => 168],
    ["branch" => "Jakarta", "posting_date" => "2024-01-06", "visitors" => 56],
    ["branch" => "Jakarta", "posting_date" => "2024-01-07", "visitors" => 300]
];
$data_y = [
    ["branch" => "Surabaya", "posting_date" => "2024-01-01", "total_transactions" => 35],
    ["branch" => "Surabaya", "posting_date" => "2024-01-02", "total_transactions" => 24],
    ["branch" => "Surabaya", "posting_date" => "2024-01-03", "total_transactions" => 8],
    ["branch" => "Surabaya", "posting_date" => "2024-01-04", "total_transactions" => 19],
    ["branch" => "Surabaya", "posting_date" => "2024-01-06", "total_transactions" => 9],
    ["branch" => "Surabaya", "posting_date" => "2024-01-07", "total_transactions" => 12],
    ["branch" => "Jakarta", "posting_date" => "2024-01-01", "total_transactions" => 135],
    ["branch" => "Jakarta", "posting_date" => "2024-01-02", "total_transactions" => 124],
    ["branch" => "Jakarta", "posting_date" => "2024-01-04", "total_transactions" => 18],
    ["branch" => "Jakarta", "posting_date" => "2024-01-05", "total_transactions" => 79],
    ["branch" => "Jakarta", "posting_date" => "2024-01-06", "total_transactions" => 19],
    ["branch" => "Jakarta", "posting_date" => "2024-01-07", "total_transactions" => 112]
];

$result = process_data($data_group, $data_x, $data_y);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case 2</title>
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