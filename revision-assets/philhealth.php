<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Rate Table 2025</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        .header {
            background-color: #1a1a1a;
            color: white;
            text-align: center;
            font-weight: bold;
            padding: 15px;
            border: 2px solid #000;
        }
        
        .year-cell {
            background-color: #f8f9fa;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            padding: 20px;
            border: 2px solid #000;
            vertical-align: middle;
        }
        
        .salary-cell, .premium-cell {
            background-color: #f8f9fa;
            text-align: center;
            padding: 12px;
            border: 2px solid #000;
            font-size: 14px;
        }
        
        .rate-cell {
            background-color: #f8f9fa;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            padding: 20px;
            border: 2px solid #000;
            vertical-align: middle;
        }
        
        .salary-range {
            font-weight: bold;
        }
        
        .premium-amount {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th class="header">Year</th>
                    <th class="header">Monthly Basic Salary</th>
                    <th class="header">Premium<br>Rate</th>
                    <th class="header">Monthly Premium</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="3" class="year-cell">2025</td>
                    <td class="salary-cell"><span class="salary-range">₱10,000.00</span></td>
                    <td rowspan="3" class="rate-cell">5.0%</td>
                    <td class="premium-cell"><span class="premium-amount">₱500.00</span></td>
                </tr>
                <tr>
                    <td class="salary-cell"><span class="salary-range">₱10,000.01 to ₱99,999.99</span></td>
                    <td class="premium-cell"><span class="premium-amount">₱500.00 to ₱5,000.00</span></td>
                </tr>
                <tr>
                    <td class="salary-cell"><span class="salary-range">₱100,000.00</span></td>
                    <td class="premium-cell"><span class="premium-amount">5,000.00</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>