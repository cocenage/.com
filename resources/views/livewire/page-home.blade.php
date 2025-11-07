<div
    x-data="carousel({
        slides: @js($slides),
        entangledActive: @entangle('active'),
    })"
    x-on:keydown.arrow-right.prevent="next()"
    x-on:keydown.arrow-left.prevent="prev()"
    class="h-full py-[80px] flex flex-col justify-between select-none"
    tabindex="0">

    {{-- Заголовок --}}
    <div class="relative h-[32px] overflow-hidden mx-[48px]">
        <template x-for="(slide, i) in slides" :key="i">
            <h1
                x-show="i === active"
                x-transition:enter="transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                x-transition:enter-start="opacity-0 translate-y-6 blur-[2px]"
                x-transition:enter-end="opacity-100 translate-y-0 blur-0"
                x-transition:leave="transition-all duration-350 ease-[cubic-bezier(0.45,0,0.55,1)]"
                x-transition:leave-start="opacity-100 translate-y-0 blur-0"
                x-transition:leave-end="opacity-0 -translate-y-10 blur-[10px]"
                class="absolute inset-0 flex items-center justify-start leading-none will-change-transform"
                x-text="slide.title"></h1>
        </template>
    </div>

    {{-- Сцена с фиксированным аспектом --}}
    <div
        class="relative w-full max-w-[620px] aspect-[1/0.8] md:aspect-[1/0.7] flex items-center justify-center overflow-hidden cursor-grab touch-pan-y select-none"
        x-on:pointerdown="startDrag($event)"
        x-on:pointermove.prevent="drag($event)"
        x-on:pointerup="endDrag($event)"
        x-on:pointerleave="endDrag($event)"
        x-on:touchstart.passive="startDrag($event)"
        x-on:touchmove.passive="drag($event)"
        x-on:touchend="endDrag($event)"
        x-on:wheel.prevent="wheel($event)"
        @click.capture="(isDragging || Math.abs(dragDeltaX) > 8) && ($event.preventDefault(), $event.stopPropagation())">

        <template x-for="(slide, index) in slides" :key="index">
            <div
                class="absolute inset-0 flex items-center justify-center"
                data-carousel-slide
                :class="slideClass(index)"
                :style="slideStyle(index)"
                @transitionend="onTransitionEnd">
                <a
                    :href="slide.url"
                    wire:navigate
                    wire:navigate.hover
                    class="absolute inset-0 flex items-center justify-center outline-none focus-visible:ring-2 ring-black/40 rounded-xl pointer-events-auto"
                    :aria-label="(slide.title ?? 'Открыть страницу')"
                    @dragstart.prevent
                    style="-webkit-tap-highlight-color: transparent;">
                    <img
                        :src="slide.image"
                        :alt="slide.title ?? ''"
                        class="max-w-full max-h-full object-contain pointer-events-none select-none"
                        draggable="false">
                </a>
            </div>
        </template>
    </div>

    {{-- Нижний индикатор --}}
    <div class="w-full px-[48px]">
        <div class="relative h-[2px] bg-[#525252]/50">
            <div
                class="absolute top-0 left-0 h-[2px] bg-[#525252] transition-all duration-300"
                :style="progressStyle"></div>
        </div>
    </div>
</div>
