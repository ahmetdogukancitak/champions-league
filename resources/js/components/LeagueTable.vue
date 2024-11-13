<template>
  <div class="league-table mb-6">
    <h2 class="text-2xl font-semibold mb-4">League Table</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 text-center">#</th>
            <th class="py-2 px-4 text-left">Team Name</th>
            <th class="py-2 px-4 text-center">Played</th>
            <th class="py-2 px-4 text-center">Won</th>
            <th class="py-2 px-4 text-center">Drawn</th>
            <th class="py-2 px-4 text-center">Lost</th>
            <th class="py-2 px-4 text-center">Goals For</th>
            <th class="py-2 px-4 text-center">Goals Against</th>
            <th class="py-2 px-4 text-center">Goal Difference</th>
            <th class="py-2 px-4 text-center">Points</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(team, index) in leagueTable"
            :key="team.team_id"
            :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
          >
            <td class="py-2 px-4 text-center">{{ index + 1 }}</td>
            <td class="py-2 px-4">{{ team.team_name }}</td>
            <td class="py-2 px-4 text-center">{{ team.played }}</td>
            <td class="py-2 px-4 text-center">{{ team.won }}</td>
            <td class="py-2 px-4 text-center">{{ team.drawn }}</td>
            <td class="py-2 px-4 text-center">{{ team.lost }}</td>
            <td class="py-2 px-4 text-center">{{ team.goals_for }}</td>
            <td class="py-2 px-4 text-center">{{ team.goals_against }}</td>
            <td class="py-2 px-4 text-center">{{ team.goal_difference }}</td>
            <td class="py-2 px-4 text-center font-semibold">{{ team.points }}</td>
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
      leagueTable: [],
    };
  },
  methods: {
    async fetchLeagueTable() {
      try {
        const response = await axios.get('/api/league-table');
        this.leagueTable = response.data;
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.fetchLeagueTable();
    // Event dinle
    this.emitter.on('data-updated', this.fetchLeagueTable);
  },
  beforeUnmount() {
    this.emitter.off('data-updated', this.fetchLeagueTable);
  },
};
</script>
