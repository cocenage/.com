<div x-data="{
        visible: false,
        init() {
            this.visible = true;

            // Скрываем при полной загрузке страницы
            if (document.readyState === 'loading') {
                window.addEventListener('load', () => {
                    setTimeout(() => this.visible = false, 1000);
                });
            } else {
                setTimeout(() => this.visible = false, 1000);
            }

            // Обработка Livewire
            window.addEventListener('livewire:init', () => {
                Livewire.hook('request', () => this.visible = true);
                Livewire.hook('commit', ({ succeed }) => {
                    succeed(() => setTimeout(() => this.visible = false, 1000));
                });
                Livewire.hook('message.failed', () => this.visible = false);
            });
        }
    }"
    x-show="visible"
    x-transition.opacity.duration.500ms
    class="fixed inset-0 z-[9999]">
    <video autoplay muted class="w-screen h-screen object-cover">
        <source src="{{ asset('videos/preloader.mp4') }}" type="video/mp4">
    </video>
</div>
