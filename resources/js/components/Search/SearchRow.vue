<template>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label v-if="showLabels">From</label>
                <vue-bootstrap-typeahead
                    v-model="query.from"
                    :data="airports"
                    :serializer="airport => `${airport.name} (${airport.iata})`"
                    @hit="setFrom"
                    placeholder="From"
                />
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label v-if="showLabels">To</label>
                <vue-bootstrap-typeahead
                    v-model="query.to"
                    :data="airports"
                    :serializer="airport => `${airport.name} (${airport.iata})`"
                    @hit="setTo"
                    placeholder="To"
                />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label v-if="showLabels">Date</label>
                <input type="text" class="form-control" placeholder="Departure date">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            showLabels: {
                type: Boolean,
                default: true,
            }
        },

        data() {
            return {
                query: {
                    from: '',
                    to: ''
                },

                airports: [],
                from: null,
                to: null,
            };
        },

        mounted() {
            //
        },

        watch: {
            'query.from': function (value) {
                axios.get(`/api/airports?query=${value}`)
                    .then((response) => {
                        this.airports = response.data.data;
                    });
            },

            'query.to': function (value) {
                axios.get(`/api/airports?query=${value}`)
                    .then((response) => {
                        this.airports = response.data.data;
                    });
            }
        },

        methods: {
            setFrom(airport) {
                this.from = airport;
            },

            setTo(airport) {
                this.from = airport;  
            },
        },
    }
</script>
