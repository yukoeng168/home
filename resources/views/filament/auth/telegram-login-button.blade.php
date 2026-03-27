<div id="telegram-login-container" class="flex flex-col items-center justify-center mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
    <div id="telegram-silent-login-status" style="display: none;" class="flex flex-col items-center space-y-3">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="text-sm text-gray-500 font-medium">កំពុងចូលគណនីរបស់អ្នក (Logging you in...)</p>
    </div>

    <div id="telegram-widget-wrapper">
        <script async src="https://telegram.org/js/telegram-widget.js?22" 
            data-telegram-login="{{ config('services.telegram.bot_username', 'YOUR_BOT_USERNAME') }}" 
            data-size="large" 
            data-auth-url="{{ route('auth.telegram.callback') }}" 
            data-request-access="write"></script>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const silentLoginStatus = document.getElementById('telegram-silent-login-status');
        const widgetWrapper = document.getElementById('telegram-widget-wrapper');

        // Check if we are inside a Telegram WebApp (Mini App)
        if (window.Telegram && window.Telegram.WebApp && window.Telegram.WebApp.initData) {
            const initData = window.Telegram.WebApp.initData;
            
            // Show loading spinner
            silentLoginStatus.style.display = 'flex';
            widgetWrapper.style.display = 'none';

            // Send initData to our silent login endpoint
            fetch("{{ route('auth.telegram.silent-callback') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ initData: initData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    console.error('Silent login failed:', data.message);
                    // Fallback to manual login
                    silentLoginStatus.style.display = 'none';
                    widgetWrapper.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error during silent login:', error);
                // Fallback to manual login
                silentLoginStatus.style.display = 'none';
                widgetWrapper.style.display = 'block';
            });
        }
    });
</script>
