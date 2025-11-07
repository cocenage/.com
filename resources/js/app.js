import "./bootstrap";

document.addEventListener("alpine:init", () => {
    Alpine.data("carousel", ({ slides, entangledActive }) => ({
        slides,
        active: entangledActive,
        // запоминаем, что было до смены
        prevActive: entangledActive,

        dragStartX: 0,
        dragDeltaX: 0, // используем только для подавления клика после свайпа
        isDragging: false, // флаг «жест начался»
        threshold: 60,
        isAnimating: false,

        get currentSlide() {
            return this.slides[this.active] ?? {};
        },

        loopIndex(i) {
            const len = this.slides.length;
            return ((i % len) + len) % len;
        },

        // offset для ПРОИЗВОЛЬНОГО active
        getOffsetFor(index, active) {
            const prev = this.loopIndex(active - 1);
            const next = this.loopIndex(active + 1);

            if (index === prev) return -1;
            if (index === active) return 0;
            if (index === next) return 1;

            return 999;
        },

        // offset для текущего состояния
        getOffset(index) {
            return this.getOffsetFor(index, this.active);
        },

        slideStyle(index) {
            const offset = this.getOffset(index);
            if (Math.abs(offset) === 999) return "";

            // важный момент:
            // «живого» перетаскивания нет — драг не влияет на позицию
            const drag =
                this.isDragging && Math.abs(offset) <= 1 ? this.dragDeltaX : 0;

            return `transform: translateX(calc(${offset * 100}% + ${drag}px));`;
        },

        slideClass(index) {
            const curr = this.getOffsetFor(index, this.active);
            const prev = this.getOffsetFor(index, this.prevActive);

            // невидимые не показываем
            if (Math.abs(curr) === 999) return "hidden";

            // если тянем — без анимации (у нас тянуть не будем, но пусть логика останется)
            if (this.isDragging) return "";

            // прыжок на 2 → без анимации
            if (Math.abs(curr - prev) > 1) return "";

            // обычный случай — анимация
            return "transition-transform duration-300 ease-out";
        },

        get progressStyle() {
            const part = 1 / this.slides.length;
            return `width: ${part * 100}%; transform: translateX(${
                this.active * 100
            }%);`;
        },

        setActive(newIndex) {
            // перед сменой запоминаем старое
            this.prevActive = this.active;
            this.active = this.loopIndex(newIndex);
            this.isAnimating = true;
        },

        next() {
            if (this.isAnimating) return;
            this.setActive(this.active + 1);
        },

        prev() {
            if (this.isAnimating) return;
            this.setActive(this.active - 1);
        },

        onTransitionEnd(e) {
            if (!e.target.closest("[data-carousel-slide]")) return;
            this.isAnimating = false;
        },

        // === ПРОСТОЙ СВАЙП: фиксируем старт, на конце измеряем дельту ===
        startDrag(e) {
            const clientX = e.clientX ?? e.touches?.[0]?.clientX ?? 0;
            this.isDragging = true; // пометим, что жест начат
            this.dragStartX = clientX;
            this.dragDeltaX = 0; // сбросим на всякий
        },

        // Ничего не делаем во время движения — «живого» перетаскивания нет
        drag(e) {
            return;
        },

        endDrag(e) {
            if (!this.isDragging) return;
            this.isDragging = false;

            const clientX = e?.clientX ?? e?.changedTouches?.[0]?.clientX ?? 0;
            const dx = clientX - this.dragStartX;

            // временно сохраняем дельту, чтобы существующий @click.capture подавил клик
            this.dragDeltaX = dx;

            if (dx > this.threshold) {
                this.prev();
            } else if (dx < -this.threshold) {
                this.next();
            }

            // через небольшой таймаут сбросим, чтобы клики дальше работали
            setTimeout(() => {
                this.dragDeltaX = 0;
            }, 250);
        },

        wheel(e) {
            if (this.isAnimating) return;

            // Нормализуем дельту для разных устройств/ОС
            const dy =
                typeof e.deltaY === "number"
                    ? e.deltaY
                    : typeof e.wheelDelta === "number"
                    ? -e.wheelDelta
                    : 0;
            const dx = typeof e.deltaX === "number" ? e.deltaX : 0;

            // Берём более «сильную» ось (трекпады часто дают и X, и Y)
            const delta = Math.abs(dx) > Math.abs(dy) ? dx : dy;

            // Мёртвая зона, чтобы не срабатывало от микроподвижек
            if (Math.abs(delta) < 10) return;

            if (delta > 0) this.next();
            else this.prev();
        },

        cancelDrag() {
            if (!this.isDragging) return;
            this.isDragging = false;
            this.dragDeltaX = 0;
        },
    }));
});
