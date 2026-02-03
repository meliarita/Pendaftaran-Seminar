<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Kampus - Sistem Manajemen Event</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        :root {
            --primary-color: #0d6efd;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfdfe; 
            color: #2d3436;
        }
        .card { 
            border-radius: 15px; 
            border: none; 
        }
        .shadow-sm { 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04) !important; 
        }
        /* Style khusus untuk area kamera scan */
        #reader {
            border: none !important;
        }
        #reader__dashboard_section_csr button {
            background-color: var(--primary-color) !important;
            color: white !important;
            border: none !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
            margin-top: 10px !important;
        }
    </style>
</head>
<body>