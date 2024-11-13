import './bootstrap';
import { createApp } from 'vue'
import LeagueTable from './components/LeagueTable.vue'
import Games from './components/Games.vue'
import Predictions from './components/Predictions.vue'
import Controls from './components/Controls.vue'
import mitt from 'mitt';
const emitter = mitt();

const app = createApp({})

app.component('league-table', LeagueTable)
app.component('games', Games)
app.component('predictions', Predictions)
app.component('controls', Controls)

app.config.globalProperties.emitter = emitter;

app.mount('#app')