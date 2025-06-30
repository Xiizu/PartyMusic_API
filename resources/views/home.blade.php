<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Music API</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle, #1a1a2e, #16213e, #0f3460);
            font-family: Arial, sans-serif;
            color: rgb(152, 248, 255);
            text-align: center;
            overflow: hidden;
        }

        h1 {
            font-size: 3rem;
            text-shadow: 2px 2px 10px rgba(84, 244, 255, 0.8);
        }

        .stars-container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            opacity: 0;
            animation: twinkle 2s infinite ease-in-out;
        }

        @keyframes twinkle {
            0% {
                opacity: 0;
                transform: scale(0);
            }
            50% {
                opacity: 1;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(0);
            }
        }
    </style>
</head>
<body>
    <div class="stars-container"></div>
    
    <img src="{{ asset('/images/PartyMusic_logo_big.png') }}" alt="Logo" style="position: absolute; left: 50%; top: 50%; width: 60vw; max-width: 700px; min-width: 300px; opacity: 0.8; transform: translate(-50%, -50%); z-index: 0; pointer-events: none; filter: brightness(0) invert(1) drop-shadow(0 0 0 black) drop-shadow(0 0 3px black) drop-shadow(0 0 6px black);">

    <div style="position: absolute; left: 50%; top: 35%; transform: translate(-50%, -50%); z-index: 1; width: 100%;">
        <h1 style="color: rgb(152, 248, 255); text-shadow: 0 0 10px #000, 0 0 20px #00eaff, 2px 2px 10px #000;">Party Music API</h1>
        <h2 style="color: rgb(152, 248, 255); text-shadow: 0 0 10px #000, 0 0 20px #00eaff, 2px 2px 10px #000;">
            <a href="{{ asset('https://github.com/Xiizu/PartyMusic_App/raw/53d133902072496b522fa85ac0d5066177bff3ff/app-debug.apk') }}" 
               style="color: #00eaff; text-decoration: underline; font-size: 1.5rem; background: rgba(0,0,0,0.3); padding: 0.5em 1em; border-radius: 8px; box-shadow: 0 0 10px #00eaff;"
               download>
            Télécharger l'application
            </a>
        </h2>
    </div>

    <script>
        const starsContainer = document.querySelector('.stars-container');

        function createStar() {
            const star = document.createElement('div');
            star.classList.add('star');

            // Random size
            const size = Math.random() * 4 + 1; // Between 1px and 4px
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;

            // Random position
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * window.innerHeight;
            star.style.left = `${x}px`;
            star.style.top = `${y}px`;

            // Random animation duration
            const duration = Math.random() * 8 + 2; // Between 2s and 5s
            star.style.animationDuration = `${duration}s`;

            starsContainer.appendChild(star);

            // Remove the star after animation ends
            setTimeout(() => {
                star.remove();
            }, duration * 1000);
        }

        // Generate stars at random intervals
        setInterval(createStar, 200); // Create a star every 200ms
    </script>
</body>
</html>