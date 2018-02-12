<template>
    <tile :position="position">
        <section class="time-weather">
            <span class="time-weather__time-zone">{{ weatherCity }}</span>
            <time class="time-weather__content">
                <span class="time-weather__date">{{ date }}</span>
                <span class="time-weather__time">{{ time }}</span>
            </time>
        </section>
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import moment from 'moment-timezone';

export default {
    components: {
        Tile,
    },

    props: {
        weatherCity: {
            type: String,
        },
        dateFormat: {
            type: String,
            default: 'DD-MM-YYYY',
        },
        timeFormat: {
            type: String,
            default: 'HH:mm',
        },
        timeZone: {
            type: String,
        },
        position: {
            type: String,
        },
    },

    data() {
        return {
            date: '',
            time: '',
        };
    },

    created() {
        this.refreshTime();
        setInterval(this.refreshTime, 1000);
    },

    methods: {
        refreshTime() {
            this.date = moment()
                .tz(this.timeZone)
                .format(this.dateFormat);
            this.time = moment()
                .tz(this.timeZone)
                .format(this.timeFormat);
        },
    },
};
</script>
