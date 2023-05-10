@extends('layout')

@section('title', 'Projekty')

@section('content')

<section class="m-5">
    <h1>Projekty</h1>
    <div class="my-3 d-flex row p-1">
        <div class="p-0 col-md-4">
            <div class='card m-1 h-100'>
                <img class="card-img-top" src="/img/projects/meteo.png" alt="Meteo">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">SŠIS Meteo</h5>
                    <p class="card-text">Závěrečný projekt z druhého ročníku střední školy</p>
                    <a class="btn btn-primary text-white mt-auto" href="//old.vofy.tech/projects/meteo?origin=web">Navštívit</a>
                </div>
            </div>
        </div>
        <div class="p-0 col-md-4">
            <div class='card m-1 h-100'>
                <img class="card-img-top" src="/img/projects/osobni.png" alt="Meteo">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Osobní web</h5>
                    <p class="card-text">Můj současně aktivní web vytvořený pomocí MERN stacku (MongoDB, Express.js, React, Node.js)</p>
                    <a class="btn btn-primary text-white mt-auto" href="//vofy.tech">Navštívit</a>
                </div>
            </div>
        </div>
        <div class="p-0 col-md-4">
            <div class='card m-1 h-100'>
                <img class="card-img-top" src="/img/projects/sup.png" alt="Meteo">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Školní učební portál</h5>
                    <p class="card-text">Projekt s cílem zlepšit výuku s pomocí ICT. Webová stránka je rozcestník jednotlivých aplikací školy.</p>
                    <a class="btn btn-primary text-white mt-auto" href="//sup.sposdk.cz">Navštívit</a>
                </div>
            </div>
        </div>
    </div>
</section>

@stop