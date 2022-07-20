<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import Badge from '@/Shared/Badge.vue';
import CreateItemForm from '@/Pages/Items/Partials/CreateItemForm.vue';
import FormModal from '@/Shared/FormModal.vue';
import moment from "moment";
import { VueTruncateHtml } from 'vue3-truncate-html';
import { CalendarIcon, ClockIcon } from '@heroicons/vue/outline'

const isTruncated = ref(true);
const displayCreateItem = ref(false);

const props = defineProps({
    projects: Object,
    users: Object,
    statuses: Object,
    priorities: Object,
});

const createItem = () => {
    displayCreateItem.value = true;
}

const closeModal = () => {
    displayCreateItem.value = null;
}

const showItem = ($number) => {
    Inertia.visit('/item/' + $number);
}
</script>

<template>
    <AppLayout title="Items">
        <template #header>
            <div class="inline-flex justify-between w-full">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Items
                </h2>
                <JetButton @click="createItem()">
                    Create
                </JetButton>
            </div>
        </template>

        <FormModal
            :show="displayCreateItem"
            @close="displayCreateItem = null"
        >
            <template #title>
                Create Item
            </template>

            <template #content>
                <template v-if="projects">
                    <CreateItemForm
                        v-bind:projects="projects"
                        v-bind:users="users"
                        v-bind:statuses="statuses"
                        v-bind:priorities="priorities"
                        @exit="closeModal"
                    />
                </template>
                <p
                    v-else
                    class="p-12 text-gray-800"
                >
                    Please create your first Project before creating an Item.
                </p>
            </template>

            <template #footer>
                <JetSecondaryButton @click="displayCreateItem = null">
                    Cancel
                </JetSecondaryButton>

                <JetButton class="ml-3">
                    Save
                </JetButton>
            </template>
        </FormModal>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 overflow-x-auto">
            <template v-if="$page.props.items.length > 0">
                <table class="table-auto w-full text-sm">
                    <thead class="table-header-group">
                        <tr class="text-left text-gray-800">
                            <th class="p-2">Number</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Description</th>
                            <th class="p-2">Project</th>
                            <th class="p-2">Account</th>
                            <th class="p-2 border-l border-gray-200">Start</th>
                            <th class="p-2 border-r border-gray-200"><span class="inline-flex justify-between w-full items-center">Due <CalendarIcon class="w–3 h-3" /></span></th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Priority</th>
                            <th class="p-2 border-l border-gray-200">Tracked</th>
                            <th class="p-2 border-r border-gray-200"><span class="inline-flex justify-between w-full items-center">Estimated <ClockIcon class="w–3 h-3" /></span></th>
                            <th class="p-2">User</th>
                        </tr>
                    </thead>
                    <tbody
                        v-for="item in $page.props.items"
                        :key="item.id"
                    >
                        <tr class="border border-gray-200 hover:bg-gray-50 text-gray-800" @click="showItem(item.number)">
                            <td class="p-2 font-semibold text-gray-600">#{{ item.number }}</td>
                            <td class="p-2">
                                <vue-truncate-html
                                    v-if="item.name"
                                    hide-button="true"
                                    v-model="isTruncated"
                                    type="text"
                                    :text="item.name"
                                    length="20"
                                />
                            </td>
                            <td class="p-2">
                                <vue-truncate-html
                                    v-if="item.description"
                                    hide-button="true"
                                    v-model="isTruncated"
                                    type="text"
                                    :text="item.description"
                                    length="20"
                                />
                            </td>
                            <td class="p-2">
                                <a class="hover:text-blue-600"
                                :href="'/project/' + item.project_number">
                                    <vue-truncate-html
                                        v-if="item.project_name"
                                        hide-button="true"
                                        v-model="isTruncated"
                                        type="text"
                                        :text="item.project_name"
                                        length="20"
                                    />
                                </a>
                            </td>
                            <td class="p-2">
                                <a class="hover:text-blue-600"
                                :href="'/accounts/' + item.account_number">
                                    {{ item.account_name }}
                                </a>
                            </td>
                            <td class="p-2">
                                <span v-if="item.start_date">
                                    {{ moment(item.start_date).format("DD/MM/YYYY") }}
                                </span>
                            </td>
                            <td class="p-2">
                                <span v-if="item.due_date">
                                    {{ moment(item.due_date).format("DD/MM/YYYY") }}
                                </span>
                            </td>
                            <td class="p-2">{{ item.status }}</td>
                            <td class="p-2">{{ item.priority }}</td>
                            <td class="p-2">{{ item.tracked }}</td>
                            <td class="p-2">{{ item.estimated }}</td>
                            <td class="p-2"><!-- TODO: Tooltip -->
                                <a href="#">
                                    <img src="https://images.unsplash.com/photo-1614622539136-fd8e06f32f31?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80"
                                        class="w-8 h-8 object-cover overflow-hidden rounded-full border-2 border-gray-200 hover:border-blue-600"
                                        :alt="item.user_name"
                                    />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <div v-else
                 class="text-3xl text-gray-600 font-semibold text-center"
            >
                No items found.
            </div>
        </div>
    </AppLayout>
</template>
