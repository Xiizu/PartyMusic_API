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
    <h1>Party Music API</h1>

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