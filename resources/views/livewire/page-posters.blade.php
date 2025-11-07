<div
    x-data="carousel({
        slides: @js($slides),
        entangledActive: @entangle('active'),
    })"
    class="relative w-full h-screen overflow-hidden select-none"
    x-on:keydown.arrow-right.prevent="next()"
    x-on:keydown.arrow-left.prevent="prev()"
    tabindex="0">

    <div class="py-[80px] px-[48px] flex flex-col gap-[8px] relative z-20">
        <h1>Постеры что-то там про душу</h1>
        <p>Мне похуй</p>
    </div>

    <div
        class="absolute inset-0 flex items-center justify-center overflow-hidden cursor-grab"
        x-on:pointerdown="startDrag($event)"
        x-on:pointermove.prevent="drag($event)"
        x-on:pointerup="endDrag($event)"
        x-on:pointerleave="cancelDrag()"
        x-on:touchstart.passive="startDrag($event)"
        x-on:touchmove.passive="drag($event)"
        x-on:touchend="endDrag($event)"
        x-on:wheel.prevent="wheel($event)">
        <template x-for="(slide, i) in slides" :key="i">
            <div
                class="absolute inset-0 flex items-center justify-center"
                data-carousel-slide
                :class="slideClass(i)"
                :style="slideStyle(i)"
                @transitionend="onTransitionEnd">
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="max-w-[min(80vw,1100px)] w-[70%] h-full object-contain will-change-transform pointer-events-none select-none">
            </div>
        </template>
    </div>
    {{-- Стрелки поверх изображения --}}
    <button
        @click="prev"
        class="absolute px-[48px] top-1/2 -translate-y-1/2 flex items-center justify-center cursor-pointer"
        aria-label="Предыдущий">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
        </svg>
    </button>
    <button
        @click="next"
        class="absolute right-[5%] top-1/2 -translate-y-1/2 flex items-center justify-center cursor-pointer"
        aria-label="Следующий">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
        </svg>
    </button>
</div>
