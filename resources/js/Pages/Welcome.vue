<script setup>
import { Head } from '@inertiajs/vue3';
import Pusher from "pusher-js";
import {reactive, ref} from "vue";
import Navigation from "@/Components/Navigation.vue";

const messages = reactive([]);
const message = ref();

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

const pusher = new Pusher('7eaa60a3df51439af249', {
  cluster: 'eu',
  // userAuthentication: {
  //   endpoint: "/pusher/user-auth",
  //   transport: "ajax",
  //   params: {},
  //   headers: {
  //    'Authorization': 'Bearer ' + token
  //   },
  //   This function is called on every request and the parameters returned are added to the request
  //   paramsProvider: null,
  //   This function is called on every request and the headers returned are added to the request
  //   headersProvider: null,
  //   customHandler: null,
  // },
});

// pusher.signin();

const channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  messages.push(data);
});

const sendMessage = () => {
  axios.post('/api/send-message', {
    message: message.value,
  }).then(() => {
    message.value = '';
  });
}
</script>

<template>
    <Head title="Welcome" />
  <Navigation />
    <div class="mx-auto max-w-7xl p-6">
      <div class="grid grid-cols-2 gap-6">
        <div class="space-y-4">
          <div v-for="message in messages">
            <div class="p-4 border rounded-md">
              <p>{{message.message}}</p>
            </div>
            <p class="mt-1 text-xs">{{message.user.name}} {{message.time}}</p>
          </div>
        </div>
        <div>
          <textarea v-model="message" class="w-full h-24 border border-gray-300 rounded-md p-2" placeholder="Type your message here"></textarea>
          <div class="flex gap-6">
            <button class="mt-4 rounded-md bg-gray-800 text-white py-2 px-3" @click="sendMessage">Send Message</button>
          </div>
        </div>
      </div>
    </div>
</template>
