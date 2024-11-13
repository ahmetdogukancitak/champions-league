<template>
  <div class="predictions mb-6">
    <h2 class="text-2xl font-semibold mb-4">Championship Predictions</h2>
    <div class="overflow-x-auto">
      <!-- Loader -->
      <div v-if="loading" class="flex justify-center items-center py-4">
        <div class="loader"></div>
        <span class="ml-2 text-gray-600">Loading...</span>
      </div>
      <!-- Message if odds are not available -->
      <div v-else-if="oddsNotAvailable" class="text-center py-4 text-gray-600">
        Championship odds will be available after Week 4.
      </div>
      <!-- Table -->
      <table
        v-else
        class="min-w-full bg-white shadow-md rounded-lg overflow-hidden"
      >
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 text-left">Team</th>
            <th class="py-2 px-4 text-center">Championship Odds (%)</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(odds, team, index) in predictions"
            :key="team"
            :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
          >
            <td class="py-2 px-4">{{ team }}</td>
            <td class="py-2 px-4 text-center font-semibold">
              {{ odds.toFixed(2) }}%
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      predictions: {},
      loading: true,
    };
  },
  computed: {
    oddsNotAvailable() {
      // Check if all odds are zero
      return (
        Object.keys(this.predictions).length > 0 &&
        Object.values(this.predictions).every((odds) => odds === 0)
      );
    },
  },
  methods: {
    async fetchPredictions() {
      this.loading = true;
      try {
        const response = await axios.get('/api/predictions');
        this.predictions = response.data;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.fetchPredictions();
    this.emitter.on('data-updated', this.fetchPredictions);
  },
  beforeUnmount() {
    this.emitter.off('data-updated', this.fetchPredictions);
  },
};
</script>

<style scoped>
/* Loader Styles */
.loader {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3490dc; /* Tailwind's blue-600 color */
  border-radius: 50%;
  width: 24px;
  height: 24px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
