<template>
    <div class="section main-search">
        <div class="container">
            <form action="" method="POST" @submit.prevent = "SubmitForm()">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="mb-3">Private Jet Charter: Fly Different Today</h1>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <div class="input-group">
                            <input
                                type="text" class="form-control"
                                placeholder="Departure Airport"
                                aria-describedby="departure-airport"
                                v-model="queryString" v-on:keyup="getStartResults"
                                name="startPoint"
                                id="startPoint"
                                autocomplete="nope"
                                >
                            <div class="input-group-prepend" >
                                <span class="input-group-text" id="departure-airport"><img src="/images/departure-icon.png" class="icon-img" alt="..."></span>
                            </div>
                        </div>
                        <div class="panel-footers"  style="width:350px" v-if="startFlag">
                            <ul class="list-group" v-if="airports.length">
                                <li class="list-group-item " v-for="airport in airports" @click="getSelected(airport.iata+'-'+airport.city)">
                                    <a>  <strong>{{ airport.iata }}</strong> , <strong>{{ airport.name }}</strong>, {{ airport.city }}, {{ airport.country.name }} </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-lg-3 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control"
                                   placeholder="Arrival Airport"
                                   aria-describedby="arrival-airport"
                                   v-model="queryEndString" v-on:keyup="getEndResults"
                                   name="endPoint"
                                   id="endPoint"
                                   autocomplete="nope"
                            >
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="arrival-airport"><img src="/images/arrival-icon.png" class="icon-img" alt="..."></span>
                            </div>
                        </div>
                        <div class="panel-footers"  style="width:350px" v-if="endFlag">
                            <ul class="list-group" v-if="airportsEnd.length">
                                <li class="list-group-item " v-for="airport in airportsEnd" @click="getEndSelected(airport.iata+'-'+airport.city)">
                                    <a>  <strong>{{ airport.iata }}</strong> , <strong>{{ airport.name }}</strong>, {{ airport.city }}, {{ airport.country.name }} </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control dateranger" range placeholder="Departure Date"
                                   aria-describedby="date-time"
                                   name="startDate"
                                   id="startDate"
                                   autocomplete="nope">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="date-time"><img src="/images/date-icon.png" class="icon-img" alt="..."></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control dateranger" range placeholder="Return Date" aria-describedby="date-time" name="endDate" id="endDate" autocomplete="nope">
                            <div class="input-group-prepend">
                                <span class="input-group-text" ><img src="/images/date-icon.png" class="icon-img" alt="..."></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <div class="input-group">
                            <input type="number" class="form-control" placeholder="Passengers" aria-describedby="passengers" name="numberPassengers" id="numberPassengers">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="passengers"><img src="/images/passengers-icon.png" class="icon-img" alt="..."></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 offset-4 col-sm-2 offset-sm-5 col-lg-1 offset-lg-0 mb-3">
                        <button type="button" class="plus-btn">
                            <img src="/images/plus.png" class="icon-img" alt="...">
                        </button>
                    </div>
                    <div class="col-lg-1 form-container-1">
                        <button type="submit" class="btn">Search</button>
                    </div>
                    <div class="col-lg-12">
                        <a href="#how-it-works"><img src="/images/scroll.png" class="scroll-button" alt="..."></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>


    export default {
        data: function(){
            return {
                queryString:'',
                queryEndString:'',
                airports:[],
                airportsEnd:[],
                startFlag:true,
                endFlag:true,
            }
        },
        methods: {
            SubmitForm: function(event) {
                console.log(event);
                axios.post('/api/search/flights', {
                    start: document.getElementById('startPoint').value,
                    end: document.getElementById('endPoint').value,
                    startDate: document.getElementById('startDate').value,
                    endDate: document.getElementById('endDate').value,
                    passengers: document.getElementById('numberPassengers').value,

                }).then(response => {
                    window.location = response.data.redirect;
                });
            },
            getStartResults: function() {
                this.startFlag = true;
                this.airports = [];
                if(this.queryString.length > 2) {
                    axios.get('/api/airports', {
                        params:
                            {
                                query: this.queryString
                            }
                    }).then(response => {
                        response.data.data.forEach((airport) => {
                            this.airports.push(airport);
                        });
                        //console.log(response.data.data[0].country.name);
                    });
                }

            },
            getEndResults: function() {
                this.endFlag = true;
                this.airportsEnd = [];
                if(this.queryEndString.length > 2) {
                    axios.get('/api/airports', {
                        params:
                            {
                                query: this.queryEndString
                            }
                    }).then(response => {
                        response.data.data.forEach((airport) => {
                            this.airportsEnd.push(airport);
                        });
                    });
                }
            },
            getSelected: function (message) {
                this.startFlag = false;
                this.queryString= message;


            },
            getEndSelected: function (message) {
                this.endFlag = false;
                this.queryEndString= message;


            }
        }
    }
</script>

<style scoped>

</style>
