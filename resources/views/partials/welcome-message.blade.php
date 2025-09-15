@if(session('success') || session('message'))
    <div id="welcome-message" class="welcome-alert">
        {{ session('success') ?? session('message') }}
    </div>

    <style>
    .welcome-alert {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px 30px;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        font-size: 16px;
        font-weight: 500;
        text-align: center;
        opacity: 0;
        animation: fadeInOut 5s ease-in-out forwards;
    }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translate(-50%, -20px); }
        10% { opacity: 1; transform: translate(-50%, 0); }
        90% { opacity: 1; transform: translate(-50%, 0); }
        100% { opacity: 0; transform: translate(-50%, -20px); }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeMessage = document.getElementById('welcome-message');
        if (welcomeMessage) {
            setTimeout(() => {
                welcomeMessage.style.display = 'none';
            }, 5000);
        }
    });
    </script>
@endif
</script>