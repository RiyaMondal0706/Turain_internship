<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPortal | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --text-dark: #2e3748;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 900px;
            width: 100%;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* Left Side Branding */
        .brand-section {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }

        .brand-section i {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        /* Form Styling */
        .form-section {
            padding: 50px;
            background: white;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.1);
            border-color: var(--primary-color);
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #2e59d9;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .role-toggle .btn-check:checked+.btn {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .brand-section {
                display: none;
                /* Hide branding on small mobile screens */
            }

            .form-section {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-5 brand-section">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="logo logo-lg"
                        style="height: 150px; width: 150px;">
                    <h1 class="fw-bold">Turain Intership</h1>
                    <p class="lead">Where careers, guidance, and opportunity connect.</p>
                    <div class="mt-4 small opacity-75">
                        &copy; 2026 Educational Global Inc.
                    </div>
                </div>

                <div class="col-md-7 form-section">
                    <div class="mb-4">
                        <h3 class="fw-bold text-dark">Sign In</h3>
                        <p class="text-muted">Enter your credentials to access your dashboard.</p>
                    </div>



                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" class="form-control" name = "email" placeholder="name@university.edu"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" class="form-control" name = "password" placeholder="••••••••"
                                required>
                        </div>

                        {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label small" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="small text-decoration-none">Forgot Password?</a>
                        </div> --}}

                        <button type="submit" class="btn btn-primary btn-login w-100 mb-3">Login to Dashboard</button>

                        {{-- <div class="text-center mb-3">
                            <span class="text-muted small">Or continue with</span>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-google text-danger"></i> Google
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-microsoft text-primary"></i> Outlook
                                </button>
                            </div>
                        </div> --}}
                        {{-- 
                        <p class="text-center small mb-0">
                            New to the platform? <a href="#" class="fw-bold text-decoration-none">Create
                                Account</a>
                        </p> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
