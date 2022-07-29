<script setup>
import { ref } from "vue";
import JetButton from '@/Jetstream/Button.vue';
import moment from "moment";
import { VueTruncateHtml } from 'vue3-truncate-html';
import { CalendarIcon } from '@heroicons/vue/outline';

const isTruncated = ref(true);
</script>

<template>
    <div class="p-4 inline-flex justify-between w-full">
        <h3 class="font-semibold text-2xl font-bold text-gray-800 leading-tight">
            Activities
        </h3>
        <JetButton @click="createItem()">
            Create
        </JetButton>
    </div>
    <div class="px-3 mt-2">
        <table
            class="table-auto w-full text-sm"
        >
            <thead class="table-header-group">
            <tr class="text-left text-gray-800">
                <th class="p-2">Number</th>
                <th class="p-2">Subject</th>
                <th class="p-2">Description</th>
                <th class="p-2 border-r border-l border-gray-200"><span class="inline-flex justify-between w-full items-center">Due <CalendarIcon class="w–3 h-3" /></span></th>
                <th class="p-2">Type</th>
                <th class="p-2">Status</th>
                <th class="p-2">Priority</th>
                <th class="p-2">User</th>
            </tr>
            </thead>
            <tbody>
                <tr class="border border-gray-200 hover:bg-gray-50 text-gray-800">
                    <td class="p-2 font-semibold text-gray-600">#rleA35</td>
                    <td class="p-2">
                        <vue-truncate-html
                            hide-button="true"
                            v-model="isTruncated"
                            type="text"
                            text="Meeting"
                            length="20"
                        />
                    </td>
                    <td class="p-2">
                        <vue-truncate-html
                            hide-button="true"
                            v-model="isTruncated"
                            type="text"
                            text="Meeting with key users to asses requirements"
                            length="20"
                        />
                    </td>
                    <td class="p-2">
                    <span>
                        {{ moment().format("DD/MM/YYYY") }}
                    </span>
                    </td>
                    <td class="p-2">Call</td>
                    <td class="p-2">Not Started</td>
                    <td class="p-2">Normal</td>
                    <td class="p-2"><!-- TODO: Tooltip -->
                        <a href="#">
                            <img src="https://images.unsplash.com/photo-1614622539136-fd8e06f32f31?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80"
                                    class="w-8 h-8 object-cover overflow-hidden rounded-full border-2 border-gray-200 hover:border-blue-600"
                                    alt="User Name"
                            />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>