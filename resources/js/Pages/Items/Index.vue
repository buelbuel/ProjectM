<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import CreateItemForm from '@/Pages/Items/Partials/CreateItemForm.vue';
import FormModal from '@/Shared/FormModal.vue';
import Pagination from '@/Shared/Pagination.vue';
import moment from "moment";
import { VueTruncateHtml } from 'vue3-truncate-html';
import { CalendarIcon, ClockIcon } from '@heroicons/vue/outline'

const isTruncated = ref(true);
const displayCreateItem = ref(false);

const props = defineProps({
    items: Object,
    projects: Object,
    users: Object,
    statuses: Object,
    priorities: Object,
    user: Object,
});

const displayCreateItemModal = () => {
    displayCreateItem.value = true;
};

const closeCreateItemModal = () => {
    displayCreateItem.value = null;
};

const showItem = ($number) => {
    Inertia.visit('/item/' + $number);
};
</script>

<template>
    <AppLayout title="Items">
        <template #header>
            <div class="inline-flex justify-between w-full">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Items
                </h2>
                <button
                    @click="displayCreateItemModal()"
                    class="btn btn-primary">
                    Create
                </button>
            </div>
        </template>

        <FormModal
            :show="displayCreateItem"
            @close="closeCreateItemModal()"
        >
            <template #title>
                Create Item
            </template>

            <template #content>
                <CreateItemForm
                    v-bind:projects="projects"
                    v-bind:users="users"
                    v-bind:statuses="statuses"
                    v-bind:priorities="priorities"
                    v-bind:user="user"
                    @exit="closeCreateItemModal()"
                />
            </template>

            <template #footer>
                <div class="btn-group">
                    <JetSecondaryButton
                        @click="displayCreateItemModal()"
                        class="btn-danger"
                    >
                        Cancel
                    </JetSecondaryButton>

                    <JetButton class="btn-primary">
                        Save
                    </JetButton>
                </div>
            </template>
        </FormModal>
        <div class="lg:max-w-7xl mx-auto py-10 overflow-x-auto">
            <template v-if="$page.props.items.data.length > 0">
                <table class="table table-compact w-full">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Project</th>
                            <th>Account</th>
                            <th class="border-l border-base-100">Start</th>
                            <th class="border-r border-base-100"><span class="inline-flex justify-between w-full items-center">Due <CalendarIcon class="w–3 h-3" /></span></th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th class="border-l border-base-100">Tracked</th>
                            <th class="border-r border-base-100"><span class="inline-flex justify-between w-full items-center">Estimated <ClockIcon class="w–3 h-3" /></span></th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template 
                            v-for="item in $page.props.items.data"
                            :key="item.number"
                        >
                            <tr @click="showItem(item.number)" class="hover">
                                <th class="font-bold text-gray-600">#{{ item.number }}</th>
                                <td>
                                    <vue-truncate-html
                                        v-if="item.name"
                                        v-bind:hide-button="true"
                                        v-model="isTruncated"
                                        type="text"
                                        :text="item.name"
                                        v-bind:length="20"
                                    />
                                </td>
                                <td>
                                    <vue-truncate-html
                                        v-if="item.description"
                                        v-bind:hide-button="true"
                                        v-model="isTruncated"
                                        type="text"
                                        :text="item.description"
                                        v-bind:length="20"
                                    />
                                </td>
                                <td>
                                    <a class="hover:text-blue-600"
                                    :href="'/project/' + item.project.number">
                                        <vue-truncate-html
                                            v-if="item.project.name"
                                            v-bind:hide-button="true"
                                            v-model="isTruncated"
                                            type="text"
                                            :text="item.project.name"
                                            v-bind:length="20"
                                        />
                                    </a>
                                </td>
                                <td>
                                    <a class="hover:text-blue-600"
                                    :href="'/accounts/' + item.account.number">
                                        {{ item.account.name }}
                                    </a>
                                </td>
                                <td>
                                    <span v-if="item.start_date">
                                        {{ moment(item.start_date).format("DD/MM/YYYY") }}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="item.due_date">
                                        {{ moment(item.due_date).format("DD/MM/YYYY") }}
                                    </span>
                                </td>
                                <td>{{ item.status.name }}</td>
                                <td>{{ item.priority.name }}</td>
                                <td>{{ item.tracked }}</td>
                                <td>{{ item.estimated }}</td>
                                <td>
                                    <div
                                        :data-tip="item.user.name"
                                        class="avatar tooltip tooltip-left"
                                    >
                                        <div class="mask mask-squircle w-6 h-6">
                                            <a href="#">
                                                <img src="https://images.unsplash.com/photo-1614622539136-fd8e06f32f31?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80"
                                                    :alt="item.user.name"
                                                />
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>
            <div v-else
                 class="text-3xl text-gray-600 font-semibold text-center"
            >
                No items found.
            </div>
        </div>
        <pagination
            class="mt-6"
            :links="items.links"
            v-if="$page.props.items.data.length > 0"
        />
    </AppLayout>
</template>
