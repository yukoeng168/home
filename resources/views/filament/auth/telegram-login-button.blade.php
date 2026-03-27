<div class="flex justify-center mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
    <script async src="https://telegram.org/js/telegram-widget.js?22" 
        data-telegram-login="{{ config('services.telegram.bot_username', 'YOUR_BOT_USERNAME') }}" 
        data-size="large" 
        data-auth-url="{{ route('auth.telegram.callback') }}" 
        data-request-access="write"></script>
</div>
