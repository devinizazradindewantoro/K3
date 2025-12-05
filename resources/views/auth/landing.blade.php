<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sales | K3 PT HM Sampoerna Tbk</title>
    <!-- Google Font: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ===== Global Reset ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #7A0000 0%, #B30000 100%);
            color: #FAF3E0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* ===== Hero Section ===== */
        .hero {
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 60px 40px;
            max-width: 700px;
            animation: fadeIn 1s ease-out forwards;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .hero h1 {
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #FAF3E0;
            letter-spacing: 1px;
        }

        .hero h1 span {
            color: #FFD369;
        }

        .hero p {
            font-size: 18px;
            color: #E8E6E3;
            margin-bottom: 40px;
        }

        /* ===== Buttons ===== */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0 10px;
        }

        .btn-primary {
            background-color: #FFD369;
            color: #4A0000;
        }

        .btn-primary:hover {
            background-color: #FFC233;
            transform: translateY(-4px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #FFD369;
            color: #FFD369;
        }

        .btn-outline:hover {
            background: #FFD369;
            color: #4A0000;
            transform: translateY(-4px);
        }

        /* ===== Footer ===== */
        footer {
            position: absolute;
            bottom: 20px;
            text-align: center;
            font-size: 14px;
            color: #E8E6E3;
        }

        footer a {
            color: #FFD369;
            text-decoration: none;
            margin: 0 5px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* ===== Animation ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== Decorative Circles ===== */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
            z-index: 0;
        }

        .circle.one {
            width: 180px;
            height: 180px;
            top: 10%;
            left: 10%;
        }

        .circle.two {
            width: 250px;
            height: 250px;
            bottom: 15%;
            right: 12%;
        }
    </style>
</head>

<body>
    <!-- Decorative Background Elements -->
    <div class="circle one"></div>
    <div class="circle two"></div>

    <!-- Hero Section -->
    <div class="hero">
        <h1><span>WEB</span> K3</h1>
        <p>Selamat datang di sistem Kesehatan dan Keselamatan Kerja <br> <b>PT HM Sampoerna Tbk</b>.</p>
        <a href="{{ url('level') }}" class="btn btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Dashboard</a>
        <a href="#" class="btn btn-outline"><i class="fa-solid fa-circle-info"></i> Tentang Kami</a>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2025 PT HM Sampoerna Tbk | <a href="#">Kebijakan Privasi</a> • <a href="#">Syarat & Ketentuan</a>
    </footer>
</body>

</html>
