<template>
  <div id="app">
    <RouterView />
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap');
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
:root {
  --forest: #2D4A2D; --forest-dark: #1A2E1A; --forest-deep: #111D11;
  --wood: #C9A87C; --wood-light: #DFC09A; --cream: #F5F0E8;
  --linen: #EDE8DF; --ink: #1A1A18; --mist: #7A7A72; --white: #FDFAF5;
  --font-display: 'Cormorant Garamond', Georgia, serif;
  --font-body: 'DM Sans', system-ui, sans-serif;
  --font-mono: 'DM Mono', 'Courier New', monospace;
}
html { scroll-behavior: smooth; }
body { font-family: var(--font-body); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; overflow-x: hidden; }
a { text-decoration: none; color: inherit; }
button { font-family: var(--font-body); cursor: pointer; border: none; }
::selection { background: var(--wood); color: var(--forest-deep); }
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: var(--cream); }
::-webkit-scrollbar-thumb { background: var(--wood); border-radius: 3px; }
</style>
