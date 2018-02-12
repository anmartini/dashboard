<template>
    <tile :position="position">
        <section class="arpa-meteo">
            <time class="arpa-meteo__content">
                <span class="arpa-meteo__aggiornamento">Aggiornato {{ oggi.aggiornamento }}</span>
                <span class="arpa-meteo__giorno">Oggi</span><br>
                <span class="arpa-meteo__dati"><img class="arpa-meteo__dati__icona" src="/images/arpa-meteo/low.svg"> <span class="arpa-meteo__dati__temperature">{{ oggi.dati.temperatura_minima }}</span> <img class="arpa-meteo__dati__icona" src="/images/arpa-meteo/high.svg"> <span class="arpa-meteo__dati__temperature">{{ oggi.dati.temperatura_massima }}</span> <span v-if="oggi.dati.precipitazioni"><img class="arpa-meteo__dati__icona" src="/images/arpa-meteo/rain.svg"> <span class="arpa-meteo__dati__rain">{{ oggi.dati.precipitazioni }}</span></span></span>
                <div class="arpa-meteo__row">
                    <div class="arpa-meteo__row__weather">
                        <div class="arpa-meteo__row__weather__description">
                            <img class="arpa-meteo__row__weather__image" :src="oggi.mattina.icona" :title="oggi.mattina.previsione">
                        </div>
                        <span class="arpa-meteo__row__weather__orario">Mattina</span>
                    </div>
                    <div class="arpa-meteo__row__weather">
                        <div class="arpa-meteo__row__weather__description">
                            <img class="arpa-meteo__row__weather__image" :src="oggi.pomeriggio.icona" :title="oggi.pomeriggio.previsione">
                        </div>
                        <span class="arpa-meteo__row__weather__orario">Pomeriggio</span>
                    </div>
                    <div class="arpa-meteo__row__weather">
                        <div class="arpa-meteo__row__weather__description">
                            <img class="arpa-meteo__row__weather__image" :src="oggi.sera_notte.icona" :title="oggi.sera_notte.previsione">
                        </div>
                        <span class="arpa-meteo__row__weather__orario">Sera / Notte</span>
                    </div>
                </div>
            </time>
            <time class="arpa-meteo__content" id="arpa-meteo__domani">
                <span class="arpa-meteo__aggiornamento">Aggiornato {{ domani.aggiornamento }}</span>
                <span class="arpa-meteo__giorno">Domani</span><br>
                <span class="arpa-meteo__dati"><img class="arpa-meteo__dati__icona" src="/images/arpa-meteo/low.svg"> <span class="arpa-meteo__dati__temperature">{{ domani.dati.temperatura_minima }}</span> <img class="arpa-meteo__dati__icona" src="/images/arpa-meteo/high.svg"> <span class="arpa-meteo__dati__temperature">{{ domani.dati.temperatura_massima }}</span> <span v-if="domani.dati.precipitazioni"><img class="arpa-meteo__dati__icona" src="/images/arpa-meteo/rain.svg"> <span class="arpa-meteo__dati__rain">{{ domani.dati.precipitazioni }}</span></span></span>
                <div class="arpa-meteo__row">
                    <div class="arpa-meteo__row__weather">
                        <div class="arpa-meteo__row__weather__description">
                            <img class="arpa-meteo__row__weather__image" :src="domani.mattina.icona" :title="domani.mattina.previsione">
                        </div>
                        <span class="arpa-meteo__row__weather__orario">Mattina</span>
                    </div>
                    <div class="arpa-meteo__row__weather">
                        <div class="arpa-meteo__row__weather__description">
                            <img class="arpa-meteo__row__weather__image" :src="domani.pomeriggio.icona" :title="domani.pomeriggio.previsione">
                        </div>
                        <span class="arpa-meteo__row__weather__orario">Pomeriggio</span>
                    </div>
                    <div class="arpa-meteo__row__weather">
                        <div class="arpa-meteo__row__weather__description">
                            <img class="arpa-meteo__row__weather__image" :src="domani.sera_notte.icona" :title="domani.sera_notte.previsione">
                        </div>
                        <span class="arpa-meteo__row__weather__orario">Sera / Notte</span>
                    </div>
                </div>
            </time>
        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: {
        position: {
            type: String,
        },
    },

    data() {
        return {
            oggi: {
                aggiornamento: '',
                dati: {
                    temperatura_minima: '',
                    temperatura_massima: '',
                    precipitazioni: '',
                    vento: '',
                },
                mattina: {
                    icona: '',
                    previsione: '',
                },
                pomeriggio: {
                    icona: '',
                    previsione: '',
                },
                sera_notte: {
                    icona: '',
                    previsione: '',
                },
            },
            domani: {
                aggiornamento: '',
                dati: {
                    temperatura_minima: '',
                    temperatura_massima: '',
                    precipitazioni: '',
                    vento: '',
                },
                mattina: {
                    icona: '',
                    previsione: '',
                },
                pomeriggio: {
                    icona: '',
                    previsione: '',
                },
                sera_notte: {
                    icona: '',
                    previsione: '',
                },
            },
        };
    },

    methods: {

        getEventHandlers() {
            return {
                'Arpa.MeteoFetched': response => {
                    this.oggi = response.oggi;
                    this.domani = response.domani;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'arpa',
            };
        },
    },
};
</script>
