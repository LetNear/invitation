<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Birthday Invitation</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: url('/images/bg2.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
        }

        .invite-container {
            max-width: 600px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            /* Increase transparency */
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            padding: 40px 35px 35px;
            text-align: center;
            transition: box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
            /* Add background blur */
        }

        .invite-container:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            transform: scale(1.02);
            /* Subtle scaling for interaction */
        }

        .banner {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .banner:hover {
            transform: scale(1.05);
        }

        h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            /* Add uppercase styling */
        }

        h2 {
            font-size: 1.7rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: #444;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #555;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .icon {
            font-size: 1.4rem;
            color: #ffa500;
            animation: bounce 1.5s infinite;
            /* Add bounce animation */
        }

        /* Form styles */
        form {
            margin-top: 15px;
            text-align: left;
        }

        label.form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: #444;
            margin-bottom: 6px;
            display: inline-block;
        }

        .form-control {
            border: 2px solid #8ec5fc;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 12px rgba(74, 144, 226, 0.6);
            outline: none;
        }

        .form-control-plaintext {
            padding: 12px 16px;
            background-color: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #ced4da;
            font-size: 1rem;
            margin-bottom: 15px;
            color: #212529;
            user-select: none;
        }

        small.text-muted {
            font-size: 0.9rem;
            color: #666;
            display: block;
            margin-top: 4px;
        }

        .error {
            color: #d93025;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 4px;
            display: block;
        }

        button.btn-primary {
            width: 100%;
            font-size: 1.15rem;
            padding: 14px 0;
            border-radius: 12px;
            font-weight: 700;
            background-color: #ffa500;
            border-color: #ffa500;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        }

        button.btn-primary:hover,
        button.btn-primary:focus {
            background-color: #ff7b00;
            border-color: #ff7b00;
            box-shadow: 0 6px 20px rgba(255, 123, 0, 0.6);
            transform: translateY(-2px);
            /* Add subtle lift effect */
            outline: none;
        }

        /* Keyframes for bounce animation */
        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .invite-container {
                padding: 25px 20px 20px;
            }

            h1 {
                font-size: 2.2rem;
            }

            h2 {
                font-size: 1.4rem;
                margin-bottom: 20px;
            }

            p {
                font-size: 1rem;
            }

            label.form-label {
                font-size: 1rem;
            }

            .form-control,
            .form-control-plaintext {
                font-size: 0.95rem;
                padding: 10px 14px;
            }

            button.btn-primary {
                font-size: 1rem;
                padding: 12px 0;
            }

            .icon {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="invite-container animate__animated animate__fadeIn">
        <img src="/images/amir_landscape.jpg" alt="Birthday Banner" class="banner img-fluid" />


        <h1>You're Invited!</h1>
        <h2>Join us for {{ $invite->event->name ?? 'Unknown' }}</h2>

        <p title="Event Date">
            <i class="fas fa-calendar-alt icon" aria-hidden="true"></i>
            <strong>Date:</strong>&nbsp;
            {{ \Carbon\Carbon::parse($invite->event->date ?? now())->format('F j, Y') }}
        </p>

        <p title="Event Location">
            <i class="fas fa-map-marker-alt icon" aria-hidden="true"></i>
            <strong>Location:</strong>&nbsp;
            {{ $invite->event->location ?? 'Unknown Location' }}
        </p>

        @if (session('message'))
            <div class="alert alert-success animate__animated animate__bounceIn" role="alert">
                {{ session('message') }}
            </div>
        @else
            <form action="{{ route('invite.rsvp', $invite->code) }}" method="POST" novalidate>
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label">Your Name:</label>
                    <p class="form-control-plaintext animate__animated animate__fadeInLeft" style="user-select:none;"
                        tabindex="0" aria-readonly="true">
                        {{ $invite->guest->name }}
                    </p>
                    <input type="hidden" name="name" value="{{ $invite->guest->name }}" />
                    @error('name')
                        <span class="error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                @php
                    $maxPlusOnes = max(0, ($invite->rsvp_limit ?? 0) - 1);
                    $currentPlusOnes = max(0, min(old('plusOnes', ($invite->rsvp_count ?? 1) - 1), $maxPlusOnes));
                @endphp

                <div class="mb-4">
                    <label for="plusOnes" class="form-label">Number of Plus Ones:</label>
                    <input type="number" id="plusOnes" name="plusOnes"
                        class="form-control animate__animated animate__fadeInRight" min="0"
                        max="{{ $maxPlusOnes }}" value="{{ old('plusOnes', $currentPlusOnes) }}"
                        aria-describedby="plusOnesHelp" required />
                    <small id="plusOnesHelp" class="text-muted">
                        Maximum plus ones allowed: {{ max(0, ($invite->guest->rsvp_limit ?? 0) - 1) }}
                    </small>
                    @error('plusOnes')
                        <span class="error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite"
                    aria-label="Submit RSVP">
                    RSVP
                </button>
            </form>
        @endif
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>
