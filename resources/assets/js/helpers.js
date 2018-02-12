import moment from 'moment';

export function formatNumber(value) {
    if (!value) {
        return 0;
    }

    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

export function addClassModifiers(base, modifiers = []) {
    if (!Array.isArray(modifiers)) {
        modifiers = modifiers.split(' ');
    }

    modifiers = modifiers.map(modifier => `${base}--${modifier}`);

    return [base, ...modifiers];
}

export function formatDuration(start) {
    return moment.duration(moment().diff(start), 'milliseconds').format('d[d] h[h] m[m]');
}

export function relativeDate(value) {
    const date = moment(value);

    if (moment().isSame(date, 'd')) {
        return 'oggi'+' alle '+date.format('HH:mm');
    }

    if (
        moment()
            .add(1, 'day')
            .isSame(date, 'd')
    ) {
        return 'domani'+' alle '+date.format('HH:mm');
    }

    if (date.isBetween(moment().add(1, 'day'), moment().add(8, 'days'), 'day')) {
        return date.format('dddd')+' alle '+date.format('HH:mm');
    }

    return 'tra ' + date.toNow(true);
}

export function relativeDateTime(value) {
    const date = moment(value);

    if (moment().diff(date, 'days') > 5) {
        return 'molto tempo fa';
    }

    if (moment().diff(date, 'days') > 1) {
        return `${moment().diff(date, 'days')} giorni fa`;
    }

    if (moment().diff(date, 'hours') >= 24) {
        return 'un giorno fa';
    }

    if (moment().diff(date, 'hours') > 1) {
        return `${moment().diff(date, 'hours')} ore fa`;
    }

    if (moment().diff(date, 'minutes') > 59) {
        return `un'ora fa`;
    }

    if (moment().diff(date, 'seconds') > 119) {
        return `${moment().diff(date, 'minutes')} minuti fa`;
    }

    if (moment().diff(date, 'seconds') >= 60) {
        return 'un minuto fa';
    }

    return 'ora';
}

export function diffInSeconds(otherMoment) {
    return moment().diff(otherMoment, 'seconds');
}

export function positionToGridAreaNotation(position) {
    const [from, to = null] = position.toLowerCase().split(':');

    if (from.length !== 2 || (to && to.length !== 2)) {
        return;
    }

    const areaFrom = `${from[1]} / ${indexInAlphabet(from[0])}`;
    const area = to
        ? `${areaFrom} / ${Number(to[1]) + 1} / ${indexInAlphabet(to[0]) + 1}`
        : areaFrom;

    return area;
}

function indexInAlphabet(character) {
    const index = character.toLowerCase().charCodeAt(0) - 96;
    return index < 1 ? 1 : index;
}
