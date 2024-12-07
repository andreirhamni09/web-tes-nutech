<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            width: 100vw;
            background-color: #f9f9f9;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        .form-section {
            flex: 1;
            padding: 40px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .form-section h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #ff4b4b;
        }

        .form-section p {
            margin-bottom: 30px;
            color: #666;
            font-size: 16px;
            text-align: center;
        }

        .form-section form {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 300px;
        }

        .form-section input {
            margin-bottom: 15px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-section button {
            padding: 12px;
            font-size: 16px;
            background: #ff4b4b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-section button:hover {
            background: #e63e3e;
        }

        .image-section {
            flex: 1;
            background: #ff4b4b;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .image-section img {
            max-width: 100%;
            height: auto;
        }

        .image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
        }

    </style>
</head>
<body>
    <div class="container">
        
        <div class="form-section">
            <h1>SIMS Web App</h1>
            <p>Masuk atau buat akun untuk memulai</p>
            <form action="/loginProses" method="post">
                <input type="email" placeholder="Masukkan email anda" name="email" id="email" require>
                <input type="password" placeholder="Masukkan password anda" name="password" id="password" require>
                <button type="submit">Masuk</button>
            </form>
        </div>
        <div class="image-section">
            <img src="{{ secure_asset('CMS Assets/login.png') }}" alt="Illustration">
        </div>
    </div>
</body>
</html>
