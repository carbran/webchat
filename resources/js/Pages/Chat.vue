<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Chat">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg flex" style="min-height: 500px; max-height: 500px;">
                    <!-- list users -->
                    <div class="w-3/12 bg-gray-200 dark:bg-gray-800 bg-opacity-25 border-r border-gray-200 dark:border-gray-600 overflow-y-scroll">
                        <ul>
                            <li v-for = "user in users" :key="user.id"
                            @click="() => {loadMessages(user.id)}"
                            :class="(userActive && userActive.id == user.id) ? 'bg-gray-200 bg-opacity-50' : ''"
                            class="p-6 text-lg text-gray-600 dark:text-gray-200 leading-7 font-semibold border-b border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-700 hover:bg-opacity-50 hover:cursor-pointer">
                                <p class="flex items-center">
                                    {{ user.name}}
                                    <span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                                </p>
                            </li>
                            
                        </ul>
                    </div>

                    <!-- box message -->
                    <div class="w-9/12 flex flex-col justify-between ">

                        <!-- messages -->
                        <div class="w-full h-full p-6 flex flex-col overflow-y-scroll">
                            <div v-for="message in messages" :key="message.id"
                                :class="(message.from_user == $page.props.auth.user.id) ? 'text-right' : ''"
                                class="w-full mb-3 message">
                                <p :class="(message.from_user == $page.props.auth.user.id) ? 'messageFromMe' : 'messageToMe'"
                                    class="inline-block p-2 rounded-md messageFromMe" style="max-width: 75%;">
                                    {{message.content}}
                                </p>
                                <span class="block mt-1 text-xs text-gray-500">{{formatDate(message.created_at) }}</span>
                            </div>
                            
                        </div>

                        <!-- form -->
                        <div v-if="userActive" class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200">
                            <form v-on:submit.prevent="sendMessage">
                                <div class="flex rounded-md overflow-hidden border border-gray-300">
                                    <input v-model="message" type="text" class="flex-1 px-4 py-2 text-sm border-none focus:ring-0">
                                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.messageFromMe{
    @apply bg-indigo-300;
}

.messageToMe{
    @apply bg-gray-300;
}
</style>

<script>
import axios from 'axios'
import moment from 'moment'
import store from '../store'

moment.locale("pt-br");

export default {
    data() {
        return {
            users: [],
            messages: [],
            userActive: null,
            message: []
        }
    },
    computed: {
        user() {
            return store.state.user
        }
    },
    methods: {
        scrollToBottom: function() {
            if(this.messages.length){
                document.querySelectorAll('.message:last-child')[0].scrollIntoView()
            }
        },
        loadMessages: async function(userId) {

            axios.get(`api/users/${userId}`).then(response =>{
                this.userActive = response.data.user;
            })

            await axios.get(`api/messages/${userId}`).then(response =>{
                this.messages = response.data.messages;
            })

            this.scrollToBottom()
        },
        sendMessage: async function() {

            await axios.post(`api/messages/store`, {
                'content': this.message,
                'to_user': this.userActive.id
            }).then(response => {
                this.messages.push({
                    'from_user': this.user.id,
                    'to_user': this.userActive.id,
                    'content': this.message,
                    'created_at': new Date().toISOString(),
                    'updated_at': new Date().toISOString()
                })

                this.message = ''
            })

            this.scrollToBottom()
        },
        formatDate: function (date) {
            return moment(date).format('DD/MM/YY HH:mm');
        }
    },
    mounted() {
        axios.get('api/users').then(response =>{
            this.users = response.data.users;
        })
    }
}
</script>