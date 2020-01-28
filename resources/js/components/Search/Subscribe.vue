<template>
    <div class="mb-2">
        <div class="" >
            <div class="alert alert-danger" role="alert" v-show="flag" >
                {{ errors.get('email')}}
            </div>
            <div class="alert alert-success" role="alert" v-show="success" >
                {{ messages.show('success')}}
            </div>
        </div>

        <form method="POST" action="client/subscribed" @submit.prevent="subscribe()">

            <div class="input-group">

                <input v-model="email"
                       name="email"
                       type="text"
                       class="form-control"
                       placeholder="Enter your email address"
                       aria-describedby="subscribe"
                >
                <div class="input-group-append">
                    <button class="btn" type="submit" id="subscribe">SUBSCRIBE</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    class Errors {
        constructor() {
            this.errors= {}
            this.messages= {}
        }
        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0]
            }
        }
        saveError(errors) {
            this.errors = errors.errors;
        }
        show(field) {
            if (this.messages[field]) {
                return this.messages[field]
            }
        }
        saveMessage(msg) {
            this.messages = msg.message;
        }


    }
    export default {
        data() {
            return {
                email: '',
                flag:false,
                success: false,
                errors: new Errors(),
                messages: new Errors(),
            };
        },

        mounted() {
           // this.subscribe();
        },

        methods: {
            subscribe() {
                axios.post('/subscribed', {
                    email: this.email,
                })
                .then(res => {
                    this.flag=false;
                    this.success=true;
                    this.email = '';
                    this.messages.saveMessage(res.data)
                    console.log(this.success);

                })
                .catch(error => {
                    console.log("failue");
                    this.flag=true;
                    this.errors.saveError(error.response.data)
                });
            }
        },
    }
</script>
