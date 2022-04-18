<template>
   <div class="row">

       <div class="col-8">
           <div class="card card-default">
               <div class="card-header">Messages</div>
               <div class="card-body p-0">
                   <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                            <strong v-if="message.user">
                                {{ message.user.first_name }} {{ message.user.last_name }} {{ message.user.name }}
                            </strong>
                            <strong v-else-if="message.administrator">
                                {{ message.administrator.name }}
                            </strong>
                            {{ message.message }}
                       </li>
                   </ul>
               </div>

               <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">
           </div>
            <span class="text-muted" v-if="activeUser" >{{ activeUser.name }} is typing...</span>
       </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2" v-for="(user, index) in users" :key="index">
                            <span v-if="user.first_name">
                                {{ user.first_name + " " + user.last_name }}
                            </span>
                            <span v-else-if="user.name">
                                {{ user.name }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

   </div>
</template>

<script>
    export default {
        props:['current_user', 'room_id'],
        data() {
            return {
                messages: [],
                newMessage: '',
                users:[],
                activeUser: false,
                typingTimer: false
                //room_id: 0,
            }
        },
        created() {
            this.fetchMessages();

            //Echo.listen
            //console.log(this.activeUser);
            //console.log('${roomId}');
            //console.log(this.room_id);

            Echo.join('chat.' + this.room_id)
                .here(user => {
                    //console.log('here');
                    console.log(user);
                    //console.log(user.guard);
                    this.users = user;
                })
                .joining(user => {
                    //console.log('joining');
                    //console.log(user);
                    this.users.push(user);
                })
                .leaving(user => {
                    //console.log('leaving');
                    //this.users = this.users.filter(u => u.id != user.id);
                    console.log(user);
                    this.users = this.users.filter(u => u.id != user.id);
                    /*
                    this.users = this.users.filter(u => {
                        if(user.first_name){
                            return u.id !==user.id;
                        }else{
                            //return u.id !==user.id;
                        }
                    });
                    */
                })
                .listen('MessageSent',(event) => {
                    this.messages.push(event.message);
                    //console.log(event.message);
                })
                .listenForWhisper('typing', user => {
                   this.activeUser = user;
                    if(this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                   this.typingTimer = setTimeout(() => {
                       this.activeUser = false;
                   }, 3000);
                })
        },
        methods: {
            fetchMessages() {
                //console.log(222);
                //console.log(this.users);
                axios.get('/messages/' + this.room_id).then(response => {
                    this.messages = response.data;
                    //console.log(response.data);
                })
            },
            sendMessage() {
                //console.log(this.newMessage);
                this.messages.push({
                    user: this.current_user,
                    message: this.newMessage,
                });

                //console.log(this.current_user);
                
                axios.post('/messages', {message: this.newMessage, room_id: this.room_id});
                this.newMessage = '';
            },
            sendTypingEvent() {
                Echo.join('chat.' + this.room_id)
                    .whisper('typing', this.current_user);
            }
        }
    }
</script>