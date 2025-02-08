<style>
    .snowflake {
        position: fixed;
        top: -10px;
        color: white;
        font-size: 24px;
        user-select: none;
    }

    @keyframes fall {
        to {
            transform: translateY(100vh);
        }
    }

    .snowflake:nth-child(odd) {
        animation-duration: 7s;
        animation-delay: -2s;
    }

    .snowflake:nth-child(even) {
        animation-duration: 6s;
        animation-delay: -1s;
    }
</style>

<script>
        const numSnowflakes = 15;

        for (let i = 0; i < numSnowflakes; i++) {
        const snowflake = $('<div class="snowflake">❄️</div>');
        $('body').append(snowflake);

        const startX = Math.random() * window.innerWidth;
        const startDelay = Math.random() * 5;
        const fallDuration = Math.random() * 10 + 5;
        const startSize = Math.random() * 10 + 10;

        snowflake.css({
            left: `${startX}px`,
            fontSize: `${startSize}px`,
            animation: `fall ${fallDuration}s linear ${startDelay}s infinite`
        });
        }
</script>