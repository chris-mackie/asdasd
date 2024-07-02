<script setup>
import { Head } from '@inertiajs/vue3';
import Pusher from "pusher-js";
import {reactive, ref} from "vue";
import Navigation from "@/Components/Navigation.vue";
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
} from '@headlessui/vue';
import { ChevronUpIcon } from '@heroicons/vue/20/solid'

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

          <div v-for="message in messages" :key="message.time">
            <Disclosure v-slot="{ open }">
              <DisclosureButton class="w-full py-2 text-left">
                <div :class="[message.user.name === $page.props.auth?.user.name ? 'bg-green-50' : 'bg-white','flex items-center justify-between p-4 border rounded-md']">
                  <p class="text-sm">{{message.message}}</p>
                  <ChevronUpIcon
                      :class="!open ? 'rotate-180 transform' : ''"
                      class="h-5 w-5 text-gray-800"
                  />
                </div>
              </DisclosureButton>
              <DisclosurePanel class="p-4 border border-gray-300 bg-gray-50 rounded-md text-gray-500">
                <pre>{{ message }}</pre>
              </DisclosurePanel>
              <p class="mt-1 text-xs">{{message.user.name}} {{message.time}}</p>
            </Disclosure>
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
