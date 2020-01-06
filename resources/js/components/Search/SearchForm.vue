<template>
    <section class="search">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Search the personal fly route</h1>
                    <p>Best way to rent the plane</p>
                </div>
            </div>

            <search-row v-for="(route, index) in routes" :show-labels="index === 0" :key="index"></search-row>

            <div class="row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary btn-block" @click.prevent="addRoute">Add route</button>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select class="custom-select">
                            <option>1 person</option>
                            <option>2 persons</option>
                            <option>3 persons</option>
                            <option>4 persons</option>
                            <option>5 persons</option>
                            <option>6 persons</option>
                            <option>7 persons</option>
                            <option>8 persons</option>
                            <option>9 persons</option>
                            <option>10 persons</option>
                            <option>11 persons</option>
                            <option>12 persons</option>
                            <option>13 persons</option>
                            <option>14 persons</option>
                            <option>15 persons</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg">I want to fly</button>
            </div>
        </div>
    </section>
    
</template>

<script>
    export default {
        data() {
            return {
                services: [],
                routes: [],
            };
        },

        mounted() {
            this.getServices();
            this.addRoute();
        },

        methods: {
            getServices() {
                axios.get('/api/services')
                    .then((response) => {
                        this.services = response.data.data;
                    })
            },

            addRoute() {
                this.routes.push({
                    from: '',
                    to: '',
                    date: '',
                });
            },
        },
    }
</script>
