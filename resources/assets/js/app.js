import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import Dashboard from './components/Dashboard';
import ArpaMeteo from './components/ArpaMeteo';
import Calendar from './components/Calendar';
import Github from './components/Github';
import InternetConnection from './components/InternetConnection';
import Lumiere from './components/Lumiere';
import Music from './components/Music';
import Npm from './components/Npm';
import Packagist from './components/Packagist';
import Tasks from './components/Tasks';
import Clock from './components/Clock';
import TimeWeather from './components/TimeWeather';
import Twitter from './components/Twitter';
import Uptime from './components/Uptime';

new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        ArpaMeteo,
        Calendar,
        Github,
        InternetConnection,
        Lumiere,
        Music,
        Npm,
        Packagist,
        Tasks,
        TimeWeather,
        Clock,
        Twitter,
        Uptime,
    },

    created() {
        let options = {
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            cluster: window.dashboard.pusherCluster,
        };

        this.echo = new Echo(options);
    },
});
