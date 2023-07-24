<template>
  <li class="col-span-1 flex flex-col divide-y divide-slate-200 rounded-lg bg-white text-center shadow">
    <div class="flex flex-1 flex-col p-8">
      <div class="mx-auto h-32 w-32 flex-shrink-0 rounded-full flex items-center justify-center bg-slate-300 text-slate-500 text-3xl">
        {{ personInitials }}
      </div>
      <h3 class="mt-6 text-sm font-medium text-slate-900">{{ person.name }}</h3>
      <dl class="mt-1 flex flex-grow flex-col justify-between">
        <dt class="sr-only">Email</dt>
        <dd class="text-sm text-slate-500">{{ person.email }}</dd>
        <dt class="sr-only">Location</dt>
        <dd class="text-sm text-slate-500">{{ person.latitude }}, {{ person.longitude }}</dd>
      </dl>
    </div>
    <div>
      <div class="-mt-px flex divide-slate-200">
        <div class="-ml-px flex w-0 flex-1">
          <a href="#" @click.prevent="openMoreInfoModal" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-slate-900">
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
            </svg>
            More info
          </a>
        </div>
      </div>
    </div>
  </li>
</template>


<script setup>
  import { defineProps, computed } from 'vue'

  const props = defineProps({
    person: {
      type: Object,
      required: true
    }
  })

  const { person } = props

  const personInitials = computed(() => {
    const [firstName, lastName] = person.name.split(' ')
    return `${firstName[0]}${lastName[0]}`
  })

  const openMoreInfoModal= () => {
    window.emitter.emit('openMoreInfoModal', { person: {
      ...person, person_initials: personInitials.value
    } })
  }

</script>