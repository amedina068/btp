<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
              <div>
                <div class="flex space-x-4" >
                  <div class="flex h-16 w-16 text-slate-500 items-center justify-center rounded-full bg-slate-300">
                    {{ person.person_initials }}
                  </div>
                  <div>
                    <p class="text-slate-900 font-medium">{{ person.name }}</p>
                    <p class="text-sm text-slate-500">{{ person.email }}</p>
                    <p class="text-sm text-slate-500 mt-2">{{ person.latitude }}, {{ person.longitude }}</p>
                  </div>
                </div>
                
                <div class="mt-3 sm:mt-5" v-if="dataFetched">
                  <div class="mt-2 text-base text-slate-700 space-y-2">
                    <p>Current weather: {{ currentWeather.main }}</p>
                    <p>Current temperature: {{ currentWeather.temp }} F</p>
                    <p>Humidity: {{ currentWeather.humidity }}</p>
                    <p class="text-sm">data fetched: {{ lastTimeFetched }}</p>
                  </div>
                </div>
                <div class="mt-3 sm:mt-5" v-else>
                  <p class="text-center font-medium text-lg">Loading weather data</p>
                </div>
              </div>
              <div class="mt-5 sm:mt-6">
                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0" @click="open = false" ref="cancelButtonRef">Close</button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import axios from 'axios'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const open = ref(false)

const person = ref({})

const weather = ref({})
const dataFetched = ref(false)

const fetchPerson = () => {
  axios.get(`http://localhost:82/api/v1/users/${person.value.id}`)
    .then(({ data }) => {
      weather.value = data.user.current_weather
      dataFetched.value = true
    })
}

const currentWeather = computed(() => ({...weather.value.data.weather[0], ...weather.value.data.main}))
const lastTimeFetched = computed(() => weather.value.last_time_fetched)

onMounted(() => {
  window.emitter.on('openMoreInfoModal', payload => {
    person.value = payload.person
    open.value = true

    dataFetched.value = false

    fetchPerson()
  })
})


</script>