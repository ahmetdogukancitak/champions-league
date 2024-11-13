<template>
  <div class="games mb-6">
    <h2 class="text-2xl font-semibold mb-4">Match Results</h2>
    <div v-for="week in weeks" :key="week" class="mb-6">
      <h3 class="text-xl font-semibold mb-2 text-center">Week {{ week }}</h3>
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 text-center">Home Team</th>
            <th class="py-2 px-4 text-center">Score</th>
            <th class="py-2 px-4 text-center">Away Team</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(game, index) in gamesByWeek(week)"
            :key="game.id"
            :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
          >
            <td class="py-2 px-4 text-center">{{ game.home_team.name }}</td>
            <td class="py-2 px-4 text-center flex items-center justify-center space-x-2">
              <input
                type="number"
                min="0"
                class="w-12 text-center border border-gray-300 rounded"
                v-model.number="game.home_team_score"
              />
              <span>-</span>
              <input
                type="number"
                min="0"
                class="w-12 text-center border border-gray-300 rounded"
                v-model.number="game.away_team_score"
              />
              <button
                class="ml-2 bg-blue-500 text-white px-2 py-1 rounded text-xs"
                @click="updateScore(game)"
              >
                Update
              </button>
            </td>
            <td class="py-2 px-4 text-center">{{ game.away_team.name }}</td>
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
      games: [],
      weeks: [],
    };
  },
  methods: {
    async fetchGames() {
      try {
        const response = await axios.get('/api/games');
        this.games = response.data;
        this.weeks = [...new Set(this.games.map(game => game.week))].sort(
          (a, b) => a - b
        );
      } catch (error) {
        console.error(error);
      }
    },
    gamesByWeek(week) {
      return this.games.filter(game => game.week === week);
    },
    async updateScore(game) {
      try {
        await axios.put(`/api/games/${game.id}`, {
          home_team_score: game.home_team_score,
          away_team_score: game.away_team_score,
        });
        alert('Skor güncellendi.');
        this.emitter.emit('data-updated');
      } catch (error) {
        console.error(error);
        alert('Skor güncellenirken bir hata oluştu.');
      }
    },
  },
  mounted() {
    this.fetchGames();
    this.emitter.on('data-updated', this.fetchGames);
  },
  beforeUnmount() {
    this.emitter.off('data-updated', this.fetchGames);
  },
};
</script>

<style scoped>
/* Ek stil gerekli değil, Tailwind CSS kullanıyoruz */
</style>
