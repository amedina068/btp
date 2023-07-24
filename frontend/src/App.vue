<template>
  <div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 lg:px-0 pb-20 pt-12">
      <div>
        <header>
          <h1 class="text-4xl font-bold tracking-wide">MyWeatherApp</h1>
        </header>
      </div>
      <div class="mt-12">
        <RouterView />
      </div>
    </div>
    
  </div>
</template>

<script setup>
import { RouterView } from "vue-router";
import mitt from 'mitt'

window.emitter = mitt()
</script>
