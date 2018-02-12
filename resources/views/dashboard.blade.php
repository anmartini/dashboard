@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="6" rows="3">
	<clock position="a1" date-format="dddd D MMMM" time-format="HH:mm:ss" time-zone="Europe/Rome" weather-city="Bologna"></clock>
	<calendar position="a2:a3"></calendar>
    <arpa-meteo position="b1:d2"></arpa-meteo>
    <tasks team-member="todo" position="e2:f2"></tasks>
    <music position="e1:f1"></music>
    <uptime position="f1:f2"></uptime>
    <lumiere position="b3:f3"></lumiere>
    <internet-connection></internet-connection>
</dashboard>

@endsection
