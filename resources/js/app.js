import "./bootstrap";

document.addEventListener("alpine:init", () => {
    Alpine.data("carousel", ({ slides, entangledActive }) => ({
        slides,
        active: entangledActive,
        // запоминаем, что было до смены
        prevActive: entangledActive,

        dragStartX: 0,
        dragDeltaX: 0,
        isDragging: false,
        threshold: 60,
        isAnimating: false,

        get currentSlide() {
            return this.slides[this.active] ?? {};
        },

        loopIndex(i) {
            const len = this.slides.length;
            return (i % len + len) % len;
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

            if (Math.abs(offset) === 999) {
                return "";
            }

            const drag =
                this.isDragging && Math.abs(offset) <= 1
                    ? this.dragDeltaX
                    : 0;

            return `transform: translateX(calc(${offset * 100}% + ${drag}px));`;
        },

        slideClass(index) {
            const curr = this.getOffsetFor(index, this.active);
            const prev = this.getOffsetFor(index, this.prevActive);

            // невидимые не показываем
            if (Math.abs(curr) === 999) {
                return "hidden";
            }

            // если тянем — без анимации
            if (this.isDragging) {
                return "";
            }

            // ВАЖНО: если было -1, стало +1 (или наоборот) — ПРЫЖОК НА 2 → без анимации
            if (Math.abs(curr - prev) > 1) {
                return "";
            }

            // обычный случай — анимация
            return "transition-transform duration-300 ease-out";
        },

        get progressStyle() {
            const part = 1 / this.slides.length;
            return `width: ${part * 100}%; transform: translateX(${this.active * 100}%);`;
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

        startDrag(e) {
            const clientX = e.clientX ?? e.touches?.[0]?.clientX ?? 0;
            this.isDragging = true;
            this.dragStartX = clientX;
            this.dragDeltaX = 0;
        },

        drag(e) {
            if (!this.isDragging) return;
            const clientX = e.clientX ?? e.touches?.[0]?.clientX ?? 0;
            this.dragDeltaX = clientX - this.dragStartX;
        },

        endDrag() {
            if (!this.isDragging) return;
            this.isDragging = false;

            if (this.dragDeltaX > this.threshold) this.prev();
            else if (this.dragDeltaX < -this.threshold) this.next();

            this.dragDeltaX = 0;
        },

        wheel(e) {
            if (this.isAnimating) return;
            const delta =
                Math.abs(e.deltaX) > Math.abs(e.deltaY) ? e.deltaX : e.deltaY;

            if (delta > 0) this.next();
            else if (delta < 0) this.prev();
        },
    }));
});

