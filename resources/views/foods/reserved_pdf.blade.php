<!DOCTYPE html>
<html>
<head>
    <title>Reserved Foods List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        p {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reserved Foods List</h1>
    <p>From {{ $startDate }} to {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>Food Name</th>
                <th>Reservation Date</th>
                <th>Reserve Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservedFoods as $reserveFood)
                <tr>
                    <td>{{ $reserveFood->food->name }}</td>
                    <td>{{ $reserveFood->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $reserveFood->reserve->some_detail }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>