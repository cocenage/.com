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
    <div class="relative h-[32px] overflow-hidden mb-8">
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

    {{-- Область с изображением --}}
    <div
        class="relative w-full max-w-[620px] aspect-[1/0.8] md:aspect-[1/0.7] flex items-center justify-center overflow-hidden cursor-grab"
        x-on:pointerdown="startDrag($event)"
        x-on:pointermove.prevent="drag($event)"
        x-on:pointerup="endDrag()"
        x-on:pointerleave="endDrag()"
        x-on:touchstart.passive="startDrag($event)"
        x-on:touchmove.passive="drag($event)"
        x-on:touchend="endDrag()"
        x-on:wheel.prevent="wheel($event)">

        <template x-for="(slide, index) in slides" :key="index">
            <div
                class="absolute inset-0"
                data-carousel-slide
                :class="slideClass(index)"
                :style="slideStyle(index)"
                @transitionend="onTransitionEnd">
                <div class="w-full h-full flex items-center justify-center">
                    <img
                        :src="slide.image"
                        alt=""
                        class="max-h-full max-w-full object-contain pointer-events-none select-none">
                </div>
            </div>
        </template>
    </div>

    {{-- Нижний индикатор --}}
    <div class="w-full">
        <div class="relative h-[2px] bg-[#525252]/50">
            <div
                class="absolute top-0 left-0 h-[2px] bg-[#525252] transition-all duration-300"
                :style="progressStyle"></div>
        </div>
    </div>
</div>
