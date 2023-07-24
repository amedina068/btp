<template>
  <main>
    <div>
      <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <PersonCard v-for="person in people" :key="person.id" :person="person" />
      </ul>
    </div>

    <MoreInfoModal/>
  </main>
</template>

<script setup>
  import PersonCard from '@/components/PersonCard.vue'
  import MoreInfoModal from '@/components/MoreInfoModal.vue'
  import { ref } from 'vue'
  import axios from 'axios'

  const people = ref([])

  const fetchPeople = () => {
    axios.get('http://localhost:82/api/v1/users')
      .then(({ data }) => people.value = data.users )
  }

  fetchPeople()
</script>