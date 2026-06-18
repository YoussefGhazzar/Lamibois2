<template>
  <div class="panel-visual" :style="containerStyle">
    <svg
      v-if="config.type === 'melamine'"
      class="panel-svg"
      viewBox="0 0 600 400"
      preserveAspectRatio="xMidYMid slice"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <linearGradient :id="`bg-${uid}`" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%"   :stop-color="config.color1"/>
          <stop offset="50%"  :stop-color="config.color2"/>
          <stop offset="100%" :stop-color="config.color3"/>
        </linearGradient>
        <filter :id="`noise-${uid}`">
          <feTurbulence type="fractalNoise" :baseFrequency="noiseFreq" numOctaves="4" stitchTiles="stitch" result="noise"/>
          <feColorMatrix type="saturate" values="0" in="noise" result="grayNoise"/>
          <feBlend in="SourceGraphic" in2="grayNoise" mode="overlay" result="blended"/>
          <feComposite in="blended" in2="SourceGraphic" operator="in"/>
        </filter>
        <linearGradient :id="`shine-${uid}`" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%"   stop-color="white" stop-opacity="0.12"/>
          <stop offset="40%"  stop-color="white" stop-opacity="0.04"/>
          <stop offset="100%" stop-color="white" stop-opacity="0"/>
        </linearGradient>
      </defs>

      <!-- Base panel color -->
      <rect width="600" height="400" :fill="`url(#bg-${uid})`"/>

      <!-- Wood grain lines (for wood type) -->
      <g v-if="config.lines === 'wood'" :opacity="0.25">
        <path v-for="(line, i) in woodGrainPaths" :key="i"
          :d="line.d" :stroke="line.color"
          :stroke-width="line.w" fill="none" opacity="0.7"
        />
      </g>

      <!-- Light melamine surface pattern -->
      <g v-if="config.lines === 'light'" opacity="0.08">
        <line v-for="i in 18" :key="i"
          :x1="0" :y1="i * 24" :x2="600" :y2="i * 24 + 5"
          :stroke="config.color3" stroke-width="1"
        />
      </g>

      <!-- Dark melamine (wengé) grain -->
      <g v-if="config.lines === 'dark'" opacity="0.35">
        <line v-for="(l, i) in darkGrainLines" :key="i"
          :x1="0" :y1="l.y1" :x2="600" :y2="l.y2"
          :stroke="l.color" :stroke-width="l.w"
        />
      </g>

      <!-- Concrete texture -->
      <g v-if="config.lines === 'concrete'" opacity="0.15">
        <rect v-for="i in 12" :key="i"
          :x="(i % 4) * 160" :y="Math.floor(i / 4) * 140"
          :width="155" :height="135"
          :fill="config.color1" :rx="1"
          :opacity="0.3 + (i % 3) * 0.1"
        />
      </g>

      <!-- Plywood layers -->
      <g v-if="config.lines === 'plywood'">
        <rect v-for="(l, i) in plywoodLayers" :key="i"
          :x="0" :y="l.y" :width="600" :height="l.h"
          :fill="l.color"
        />
        <line v-for="(l, i) in plywoodLayers" :key="'b'+i"
          :x1="0" :y1="l.y" :x2="600" :y2="l.y"
          stroke="#2D1A10" stroke-width="1.5" opacity="0.5"
        />
      </g>

      <!-- Solid wood grain -->
      <g v-if="config.lines === 'solid'" opacity="0.3">
        <path v-for="(p, i) in solidGrainPaths" :key="i"
          :d="p.d" :stroke="p.color" :stroke-width="p.w" fill="none"
        />
      </g>

      <!-- Noise overlay -->
      <rect width="600" height="400" :fill="`url(#bg-${uid})`" :filter="`url(#noise-${uid})`" opacity="0.05"/>

      <!-- Surface shine -->
      <rect width="600" height="400" :fill="`url(#shine-${uid})`"/>

      <!-- Panel edge (top and left bevel) -->
      <line x1="0" y1="0" x2="600" y2="0" :stroke="edgeLight" stroke-width="2" opacity="0.6"/>
      <line x1="0" y1="0" x2="0" y2="400" :stroke="edgeLight" stroke-width="2" opacity="0.5"/>
      <line x1="0" y1="399" x2="600" y2="399" :stroke="edgeDark" stroke-width="1.5" opacity="0.5"/>
      <line x1="599" y1="0" x2="599" y2="400" :stroke="edgeDark" stroke-width="1.5" opacity="0.5"/>
    </svg>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  config: { type: Object, required: true }
})

// Unique ID for SVG filters
const uid = Math.random().toString(36).slice(2, 7)

const noiseFreq = computed(() => {
  const map = { light: '0.65', wood: '0.45', dark: '0.55', concrete: '0.75', plywood: '0.5', solid: '0.4' }
  return map[props.config.lines] || '0.65'
})

const containerStyle = computed(() => ({
  width: '100%',
  height: '100%',
  position: 'absolute',
  inset: 0,
}))

const edgeLight = computed(() => {
  const map = { light: '#ffffff', wood: '#E8C898', dark: '#5C3D25', concrete: '#C8C4BE', plywood: '#DFC090', solid: '#F0DDB0' }
  return map[props.config.lines] || '#ffffff'
})

const edgeDark = computed(() => {
  const map = { light: '#C0BBAE', wood: '#7A5030', dark: '#0A0604', concrete: '#5A5550', plywood: '#8B6030', solid: '#9A7040' }
  return map[props.config.lines] || '#888'
})

// Wood grain paths for oak type
const woodGrainPaths = [
  { d: 'M0,40 C80,36 160,44 240,38 S400,42 600,38',    color: '#8B6030', w: 3 },
  { d: 'M0,80 C100,84 200,76 300,82 S500,76 600,80',   color: '#A07040', w: 5 },
  { d: 'M0,120 C60,116 140,124 220,118 S420,124 600,120', color: '#7A5020', w: 2 },
  { d: 'M0,160 C120,164 220,156 320,162 S500,156 600,162', color: '#9A7050', w: 4 },
  { d: 'M0,200 C90,196 190,204 290,198 S480,204 600,198', color: '#8B6030', w: 3 },
  { d: 'M0,240 C70,244 150,236 260,242 S460,236 600,242', color: '#A08050', w: 6 },
  { d: 'M0,280 C110,276 210,284 310,278 S510,284 600,278', color: '#7A5020', w: 2 },
  { d: 'M0,320 C80,324 180,316 280,322 S480,316 600,322', color: '#9A7040', w: 4 },
  { d: 'M0,360 C100,356 200,364 300,358 S500,364 600,358', color: '#8B6030', w: 3 },
]

// Dark grain for wengé
const darkGrainLines = [
  { y1: 30,  y2: 28,  color: '#0A0604', w: 4 },
  { y1: 70,  y2: 73,  color: '#1A0E08', w: 8 },
  { y1: 110, y2: 107, color: '#0A0604', w: 3 },
  { y1: 150, y2: 153, color: '#1A0E08', w: 6 },
  { y1: 190, y2: 187, color: '#0A0604', w: 4 },
  { y1: 230, y2: 233, color: '#1A0E08', w: 10 },
  { y1: 270, y2: 267, color: '#0A0604', w: 3 },
  { y1: 310, y2: 313, color: '#1A0E08', w: 7 },
  { y1: 350, y2: 347, color: '#0A0604', w: 5 },
  { y1: 380, y2: 383, color: '#1A0E08', w: 4 },
]

// Plywood cross-section layers
const plywoodLayers = [
  { y: 0,   h: 52,  color: '#D4B896' },
  { y: 52,  h: 14,  color: '#8B6030' },
  { y: 66,  h: 52,  color: '#C9A870' },
  { y: 118, h: 14,  color: '#7A5020' },
  { y: 132, h: 52,  color: '#D4B896' },
  { y: 184, h: 14,  color: '#8B6030' },
  { y: 198, h: 52,  color: '#C9A870' },
  { y: 250, h: 14,  color: '#7A5020' },
  { y: 264, h: 52,  color: '#D4B896' },
  { y: 316, h: 14,  color: '#8B6030' },
  { y: 330, h: 70,  color: '#C9A870' },
]

// Solid wood grain paths
const solidGrainPaths = [
  { d: 'M280,0 C275,40 285,80 278,120 S282,160 276,200 S284,240 278,280 S282,320 276,400', color: '#B07840', w: 3 },
  { d: 'M300,0 C297,50 303,100 298,150 S304,200 297,250 S303,300 297,400',                 color: '#C09050', w: 5 },
  { d: 'M320,0 C317,45 323,90 318,140 S324,190 318,240 S323,290 317,400',                 color: '#A07030', w: 2 },
  { d: 'M260,0 C255,35 265,70 258,110 S264,150 258,200 S265,250 258,400',                 color: '#B08040', w: 4 },
  { d: 'M340,0 C337,40 343,80 337,130 S343,180 338,230 S343,280 337,400',                 color: '#C09050', w: 3 },
  { d: 'M240,0 C236,45 244,90 238,140 S244,190 237,250 S244,310 237,400',                 color: '#A07030', w: 2 },
  { d: 'M360,0 C357,38 363,76 357,120 S364,164 357,210 S364,260 357,400',                 color: '#B08040', w: 4 },
]
</script>

<style scoped>
.panel-visual { width: 100%; height: 100%; position: absolute; inset: 0; }
.panel-svg    { width: 100%; height: 100%; display: block; }
</style>
