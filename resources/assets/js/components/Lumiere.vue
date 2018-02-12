<template>
    <tile :position="position">
        <section class="lumiere">
            <span class="lumiere__title">Oggi in Cineteca</span>
            <div class="film" v-for="film in programmazione">
                <div v-if="film.immagine" class="film__attachment">
                    <img class="film__attachment__image" :src="film.immagine"/>
                </div>
                <span class="film__titolo">{{ film.titolo }}</span>
                <div class="film__proiezioni">
                    <span class="film__proiezioni__proiezione" v-for="orario in film.proiezioni">{{ getOrario(orario.date) }}</span>
                </div>
            </div>
        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import moment from 'moment';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            programmazione: [],
        };
    },

    methods: {

        getEventHandlers() {
            return {
                'Lumiere.ProgrammazioneFetched': response => {
                    this.programmazione = response.programmazione;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'lumiere',
            };
        },

        getOrario(stringa) {
            return moment(stringa).format('HH:mm');
        },
    },

};
</script>
