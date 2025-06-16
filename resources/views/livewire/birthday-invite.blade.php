<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Invitation</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: linear-gradient(135deg, #8ec5fc 0%, #e0c3fc 100%);
            padding: 20px;
            overflow: hidden;
            color: #333;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .invite-container {
            max-width: 90%;
            width: 600px;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .error {
            color: red;
        }
        .banner {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .icon {
            font-size: 50px;
            margin: 10px;
            color: #62b0e8;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.5;
            z-index: 0;
        }
        .shape.one {
            background-color: #cfd9df;
            width: 200px;
            height: 200px;
            top: -50px;
            left: -50px;
            animation: float 6s ease-in-out infinite;
        }
        .shape.two {
            background-color: #e2ebf0;
            width: 150px;
            height: 150px;
            bottom: -40px;
            right: -40px;
            animation: float 8s ease-in-out infinite;
        }
        .globe {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 70%;
            height: auto;
            max-width: 300px;
            max-height: 300px;
            transform: translate(-50%, -50%);
            background-image: url('https://via.placeholder.com/300?text=Globe');
            background-size: cover;
            border-radius: 50%;
            z-index: -1;
            animation: rotate 20s linear infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(20px); }
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .form-control:focus {
            border-color: #8ec5fc;
            box-shadow: 0 0 8px rgba(142, 197, 252, 0.5);
        }
        .btn-primary {
            background-color: #8ec5fc;
            border-color: #8ec5fc;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #62b0e8;
            border-color: #62b0e8;
        }

        /* Make sure images and other elements are responsive */
        img, .globe {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="globe"></div>
    <div class="shape one"></div>
    <div class="shape two"></div>
    <div class="invite-container animate__animated animate__fadeIn">
        <img src="https://via.placeholder.com/600x200?text=Around+the+World+Party" class="banner" alt="Around the World">
        <h1 class="mb-4">You're Invited!</h1>
        <h2 class="mb-3">Join us for [Child’s Name]’s 1st Birthday!</h2>
        <p class="mb-1"><strong>Date:</strong> [Event Date]</p>
        <p class="mb-3"><strong>Location:</strong> [Event Location]</p>
        <i class="fas fa-globe-americas icon"></i>
        <i class="fas fa-landmark icon"></i>

        @if(session('message'))
            <div class="alert alert-success animate__animated animate__bounceIn">{{ session('message') }}</div>
        @else
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name:</label>
                    <input type="text" id="name" name="name" class="form-control animate__animated animate__fadeInLeft" value="{{ old('name') }}">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="plusOnes" class="form-label">Number of Plus Ones:</label>
                    <input type="number" id="plusOnes" name="plusOnes" class="form-control animate__animated animate__fadeInRight" min="0" max="{{ $invitation->rsvp_limit - 1 }}" value="{{ old('plusOnes') }}">
                    @error('plusOnes') <span class="error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite">RSVP</button>
            </form>
        @endif
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>