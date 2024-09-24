<!DOCTYPE html>
<html lang="zxx">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="Task Load Server">
    <meta name="author" content="Task Load Server">

    <title>التسجيل في الادمن الخاص</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..700&display=swap" rel="stylesheet">

    <style>
        body, h1, h2, h3, h4, input, button, select {
            font-family: "Cairo", sans-serif;
            background-color: #FAFAFA;
            color: #262626;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and alignment */
        .vh-100 {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: #FFFFFF;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-radius: 24px;
            padding: 40px;
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        .logo img {
            max-width: 80px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 5px;
        }

        h3 {
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            background-color: #f7f7f7;
            border-radius: 12px;
            padding: 14px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: #3897f0;
            box-shadow: 0 0 5px rgba(56, 151, 240, 0.2);
            outline: none;
        }

        .btn {
            padding: 14px;
            font-size: 16px;
            border-radius: 12px;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .btn-primary {
            background-color: #3897f0;
            color: white;
        }

        .btn-primary:hover {
            background-color: #3181db;
            transform: scale(1.02);
        }

        .btn-secondary {
            background-color: #8e8e8e;
            color: white;
        }

        .btn-secondary:hover {
            transform: scale(1.02);
        }

        .text-center {
            text-align: center;
        }

        /* Mobile Responsive */
        @media (max-width: 576px) {
            .card {
                padding: 30px;
            }

            h3 {
                font-size: 24px;
            }

            .btn {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- Registration Form -->
    <div class="vh-100">
        <div class="card">
            <div class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="img">
            </div>

            <h3>تسجيل حساب جديد</h3>
            <p class="fs-14 text-dark my-4">برجاء ملئ البيانات للتسجيل</p>

            <form class="form-horizontal" action="{{ route('admin.register') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="الاسم" required>
                </div>

                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="الايميل" required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="الباسورد" required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="تأكيد الباسورد" required>
                </div>

                <div class="form-group">
                    <select name="role" class="form-control" required>
                        <option value="" disabled selected>اختر نوع المستخدم</option>
                        <option value="admin">ادمن</option>
                        <option value="employee">موظف</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">تسجيل</button>
            </form>

            <div class="text-center mt-3">
                <p>هل لديك حساب بالفعل؟</p>
                <a href="{{ route('login.form') }}" class="btn btn-secondary">تسجيل الدخول</a>
            </div>
        </div>
    </div>


</body>
</html>
