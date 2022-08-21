<template>
    <div class="d-flex justify-content-center p-1">
        <div class="row w-100 ">
            <div class="col-12 px-0">
                <div class="card card-default">
                    <!-- Chat header -->
                    <div class="card-header ">
                        <div class="d-inline-flex w-100">
                            <div class="w-50">
                                Messages
                                <div v-if="isLoading" class="spinner-border spinner-border-sm ml-1" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="d-inline-flex w-50 justify-content-end">
                                <div class="input-group">
                                    <input class="form-control py-2 border-right-0 border" type="text"
                                        placeholder="search..." v-model="searchString" @keyup.enter="serchMessage"
                                        @input="removeAlert">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                            <i v-if="showBackBtn" @click="backToChat">Back To Chat</i>
                                            <i v-else @click="serchMessage" class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chat body -->
                    <div class="card-body p-0">
                        <div v-if="messages.length === 0" class="text-center pt-1">{{ noHistoryMessage }}</div>
                        <div id="chat-scroll-content" class="d-flex flex-column-reverse w-100 chat-history-container "
                            @scroll.passive="scrollHandler">

                            <div class="m-2 message-container" v-for="(message, index) in messages" :key="index"
                                :class="{ 'align-self-end': isMessageOwner(message) }">

                                <div class="author-title-container font-italic">
                                    <div v-if="message.user">
                                        {{ message.user.first_name }} {{ message.user.last_name }} {{
                                        message.user.name
                                        }}
                                    </div>
                                    <div v-else-if="message.administrator">
                                        {{ message.administrator.name }}
                                    </div>
                                </div>

                                <div class="mt-1 chat-text-container font-weight-bold">
                                    {{ message.message }}
                                </div>

                                <div class="date-chat-container text-right">
                                    {{ new Date(message.created_at || new Date()).toLocaleString('en-US') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chat footer -->
                    <div class="card-footer d-inline-flex justify-content-center pb-2">
                        <input @input="removeAlert" @keyup.enter="sendMessage" v-model="newMessage" type="text"
                            name="message" placeholder="Enter your message..." class="form-control w-75">

                        <button id="test-id" type="button" class="ml-2 btn btn-primary pl-4 pr-4 chat-send-message"
                            @click="sendMessage" :disabled="newMessage.trim().length === 0">Send</button>
                    </div>
                </div>
                <!-- Error Container -->
                <div v-if="isError" class='alert alert-danger mt-1'>
                    {{ errorMessage }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as Constants from '../constants';

export default {
    props: ['initUser', 'initRoomId'],
    data() {
        return {
            current_user: this.initUser ? this.initUser : null,
            room_id: this.initRoomId ? this.initRoomId : null,
            isAdmin: !!this.initUser,

            isLoading: false,
            showBackBtn: false,
            messages: [],
            newMessage: '',
            users: [],
            searchString: '',
            nextPage: null,
            noHistoryMessage: Constants.ERROR_NO_HISTORY,

            isError: false,
            errorMessage: '',
        }
    },
    async created() {

        if (!this.current_user || !this.room_id) {
            await this.getInitData();
        }

        if (!this.current_user || !this.room_id) {
            this.showAlert(Constants.ERROR_CONNECTION_PROBLEM);
        }

        await this.fetchMessages();

        Echo.join('chat.' + this.room_id)
            .here(user => {
                this.users = user;
            })
            .joining(user => {
                this.users.push(user);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.id != user.id);
            })
            .listen('MessageSent', (event) => {
                this.messages.unshift(event.message);
            })
    },
    methods: {
        async getInitData() {
            const response = await this.makeRequest('chat');
            if (response) {
                this.current_user = response.data.data.user;
                this.room_id = response.data.data.room_id;
            }
        },
        async scrollHandler(event) {
            const { scrollTop, offsetHeight, scrollHeight } = event.target;
            if (
                (scrollTop + scrollHeight) - offsetHeight === 0
                && this.nextPage && !this.isLoading
                ) {
                await this.fetchNextPage();
            }
        },
        async serchMessage() {
            if (this.searchString.trim().length === 0) {
                return;
            }
            this.isLoading = true;
            const response = await this.makeRequest(
                this.isAdmin
                    ? Constants.PREFIX_ADMIN + Constants.SEARCH_MESSAGES_PATH(this.room_id, this.searchString)
                    : Constants.SEARCH_MESSAGES_PATH(this.room_id, this.searchString),
                'GET'
            );

            if (response?.data?.data?.length === 0) {
                this.showAlert('No messages found');
            } else {
                this.messages = response.data.data;
                this.nextPage = response.data.links.next;
                this.showBackBtn = true;
            }
            this.isLoading = false;
        },
        async fetchNextPage() {
            this.isLoading = true;
            const response = await this.makeRequest(
                this.nextPage,
                'GET',
            );

            if (response) {
                this.messages = this.messages.concat(response.data.data);
                this.nextPage = response.data.links.next;
            }
            this.isLoading = false;
        },
        async fetchMessages() {
            this.isLoading = true;
            const response = await this.makeRequest(
                this.isAdmin 
                    ? Constants.PREFIX_ADMIN + `${Constants.MESSAGES_ROOT_PATH}/${this.room_id}`
                    : `${Constants.MESSAGES_ROOT_PATH}/${this.room_id}`,
                'GET'
            );

            if (response) {
                this.messages = response.data.data;
                this.nextPage = response.data.links.next;
            }
            this.isLoading = false;
        },
        async sendMessage() {
            if (this.newMessage.trim().length === 0) {
                this.showAlert('Write something!');
                return;
            }
            this.isLoading = true;

            this.showBackBtn && await this.backToChat();

            const response = await this.makeRequest(
                this.isAdmin ? Constants.PREFIX_ADMIN + Constants.MESSAGES_ROOT_PATH : Constants.MESSAGES_ROOT_PATH,
                'POST',
                {
                    message: this.newMessage,
                    room_id: this.room_id
                },
            );

            if (response) {
                this.messages.unshift({
                    user: this.isAdmin ? null : this.current_user,
                    administrator: this.isAdmin ? this.current_user : null,
                    message: this.newMessage,
                });
                this.newMessage = '';
            }
            this.isLoading = false;
        },
        async makeRequest(url, method = 'GET', data = {}) {
            try {
                const response = await axios({
                    method: method,
                    url,
                    data
                });
                return response;
            } catch (e) {
                console.log('>> ', e);
                this.showAlert(Constants.ERROR_CONNECTION_PROBLEM);
            }
        },
        async backToChat() {
            this.showBackBtn = false;
            await this.fetchMessages();
            $('#chat-scroll-content').scrollTop(0);
        },
        isMessageOwner(message) {
            if (!this.isAdmin && message.user) {
                return true;
            }
            if (this.isAdmin && message.administrator) {
                return true;
            }
            return false;
        },
        showAlert(message) {
            this.errorMessage = message;
            this.isError = true;
        },
        removeAlert() {
            this.isError = false;
            this.errorMessage = '';
        }
    }
}
</script>
