<template>
    <div class="marquee-container" ref="container">
        <div class="marquee-track" :style="marqueeStyle" ref="track">
            <span class="marquee-text"><a :href="discountRoute">{{ text }}</a></span>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from 'vue'

const container = ref(null)
const track = ref(null)

const text = "Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!"
const duration = ref(40) // seconds

const discountRoute = '/discounts'
const marqueeStyle = computed(() => ({
    animation: `scroll-left ${duration.value}s linear infinite`
}))

onMounted(async () => {
    await nextTick()

    const containerWidth = container.value.offsetWidth
    const trackWidth = track.value.offsetWidth / 2 // één herhaling

    const speed = 25 // pixels per seconde
    duration.value = trackWidth / speed
})
</script>

<style>
@keyframes scroll-left {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

.marquee-container {
    overflow: hidden;
    white-space: nowrap;
    width: 100%;
    position: relative;
}

.marquee-track {
    display: inline-block;
    white-space: nowrap;
    will-change: transform;
}

.marquee-text {
    display: inline-block;
    padding-right: 2rem; /* kleine ruimte tussen herhalingen */

    a, a:hover{
        text-decoration: none;
        color:yellow;
    }
}

</style>
