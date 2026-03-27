<x-filament-widgets::widget>
    @if(auth()->user()->telegram_id === null)
        <div class="fi-section p-4 bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-900 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-100 dark:bg-amber-900 rounded-lg">
                    <x-heroicon-o-information-circle class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-amber-900 dark:text-amber-100">Connect Telegram</h3>
                    <p class="text-sm text-amber-700 dark:text-amber-300">
                        Stay updated with real-time notifications by connecting your Telegram account.
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <script async src="https://telegram.org/js/telegram-widget.js?22" 
                    data-telegram-login="{{ config('services.telegram.bot_username', 'YOUR_BOT_USERNAME') }}" 
                    data-size="medium" 
                    data-auth-url="{{ route('auth.telegram.callback') }}" 
                    data-request-access="write"></script>
            </div>
        </div>
    @endif
</x-filament-widgets::widget>
