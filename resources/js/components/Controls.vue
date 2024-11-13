<template>
  <div class="controls flex justify-center space-x-4 mb-6">
    <button @click="simulateWeek" class="btn-primary">
      Play Week
    </button>
    <button @click="simulateAll" class="btn-primary">
      Play All
    </button>
    <button @click="resetFixtures" class="btn-danger">
      Reset Fixtures
    </button>
  </div>
</template>

<script>
export default {
  methods: {
    async simulateWeek() {
      // Find the next week to simulate
      const week = await this.getNextWeekToSimulate();
      if (week) {
        try {
          await axios.post('/api/simulate-week', { week });
          alert(`Week ${week} matches have been simulated.`);
          // Emit event
          this.emitter.emit('data-updated');
        } catch (error) {
          console.error(error);
        }
      } else {
        alert('All weeks have been simulated.');
      }
    },
    async simulateAll() {
      try {
        await axios.post('/api/simulate-all');
        alert('All matches have been simulated.');
        // Emit event
        this.emitter.emit('data-updated');
      } catch (error) {
        console.error(error);
      }
    },
    async resetFixtures() {
      if (
        confirm(
          'Are you sure you want to reset the fixtures? This action cannot be undone.'
        )
      ) {
        try {
          await axios.post('/api/reset-fixtures');
          alert('Fixtures have been reset and regenerated.');
          this.emitter.emit('data-updated');
        } catch (error) {
          console.error(error);
        }
      }
    },
    async getNextWeekToSimulate() {
      try {
        const response = await axios.get('/api/games');
        const games = response.data;
        const unplayedGames = games.filter(
          (game) => game.home_team_score === null
        );
        if (unplayedGames.length > 0) {
          return unplayedGames[0].week;
        } else {
          return null;
        }
      } catch (error) {
        console.error(error);
        return null;
      }
    },
  },
};
</script>

<style lang="postcss" scoped>
.btn-primary {
  @apply inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-sm
    leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg
    focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
    active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out;
}

.btn-danger {
  @apply inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-sm
    leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg
    focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0
    active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out;
}
</style>
