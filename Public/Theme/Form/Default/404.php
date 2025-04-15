<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - 页面未找到</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", "Helvetica Neue", sans-serif;
            background: #eef6fb;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('your-rip-paper-bg.jpg'); /* 可选撕裂背景图 */
            background-size: cover;
            background-position: center;
        }

        .container {
            background: #ffffffcc;
            padding: 60px 40px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(90, 173, 226, 0.2);
            text-align: center;
            width: 500px;
            animation: floatIn 0.6s ease-out;
        }

        @keyframes floatIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container h1 {
            font-size: 72px;
            margin: 0;
            color: #5dade2;
        }

        .container p {
            font-size: 18px;
            margin: 20px 0;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #5dade2;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #3498db;
        }

        @media (max-width: 600px) {
            .container {
                width: 300px;
                padding: 40px 20px;
            }
            .container h1 {
                font-size: 48px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>404</h1>
    <p><?= $title ?></p>
    <a href="/" class="btn">返回首页</a>
</div>
</body>
</html>
