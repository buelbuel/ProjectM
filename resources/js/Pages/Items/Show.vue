<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import ActivitySection from "@/Pages/Items/Partials/ActivitySection.vue";
import CommentSection from "@/Pages/Items/Partials/CommentSection.vue";
import FileSection from "@/Pages/Items/Partials/FileSection.vue";
import Textarea from '@/Shared/Textarea.vue';
import moment from "moment";
import { VueTruncateHtml } from 'vue3-truncate-html';
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue';
import {
    SelectorIcon,
    CheckIcon,
} from '@heroicons/vue/outline';

const isTruncated = ref(true);

const props = defineProps({
    item: Object,
    projects: Object,
    users: Object,
    statuses: Object,
    priorities: Object,
});

const projects = props.projects;
const users = props.users;
const statuses = props.statuses;
const priorities = props.priorities;

// TODO: Change Select to Combobox https://headlessui.dev/vue/combobox
const selectedProject = ref(projects[0]);
const selectedUser = ref(users[0]);
const selectedStatus = ref(statuses[0]);
const selectedPriority = ref(priorities[0]);

const form = useForm({
    number: props.item.number,
    name: '',
    description: '',
    user_id: selectedUser.value['id'],
    project_id: selectedProject.value['id'],
    status_id: selectedStatus.value['id'],
    priority: selectedPriority.value['id'],
    start_date: '',
    due_date: '',
    tracked: '',
    estimated: '',
    created_at: moment().format('DD-MM-YYYY'),
});

const deleteItem = () => {
    form.delete(route('item.destroy', props.item), {
        errorBag: 'deleteItem',
    });
};
</script>

<template>
    <AppLayout :title="$page.props.item.name">
        <template #header>
            <div class="inline-flex justify-between w-full">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    #{{ $page.props.item.number }}
                </h2>
                <div class="inline-flex justify-end w-full space-x-3">
                    <form
                        @submit.prevent="deleteItem()"
                        class="inline-flex items-center"
                    >
                        <JetDangerButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Delete
                        </JetDangerButton>
                    </form>
                    <form
                        @submit.prevent="editItem()"
                        class="inline-flex items-center"
                    >
                        <JetButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Edit
                        </JetButton>
                    </form>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 grid grid-cols-4 gap-4">
            <div class="col-span-3 space-y-4">
                <div class="grid grid-cols-4 gap-4 pb-4">
                    <div class="col-span-3"><!-- TODO: Move to edititemform -->
                        <JetLabel for="name" value="Name" />
                        <JetInput
                            type="text"
                            :value="$page.props.item.name"
                            class="font-bold"
                            id="name"
                        />
                    </div>
                    <div class="col-span-1">
                        <JetLabel for="user_name" value="User" />
                        <Listbox v-model="selectedUser">
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative cursor-default text-left px-3 py-1.5 w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50"
                                >
                                    <span class="block truncate">{{ selectedUser.name }}</span>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                    >
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition
                                    leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <ListboxOptions
                                        class="absolute max-h-60 w-full overflow-auto bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                    >
                                        <ListboxOption
                                            v-slot="{ active, selected }"
                                            v-for="user in $page.props.users"
                                            :key="user.id"
                                            :value="user"
                                            as="template"
                                        >
                                            <li
                                                :class="[
                                                active ? 'bg-gray-50 text-blue-800' : 'text-gray-800',
                                                'relative cursor-default select-none py-2 pl-10 pr-4',
                                                ]"
                                            >
                                                <span
                                                    :class="[
                                                    selected ? 'font-medium' : 'font-normal',
                                                    'block truncate',
                                                ]"
                                                >
                                                    {{ user.name }}
                                                </span>
                                                <span
                                                    v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-800"
                                                >
                                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>

                    </div>
                    <div class="col-span-4">
                        <JetLabel for="description" value="Description" />
                        <Textarea
                            placeholder="No Description for this Item yet."
                            :value="$page.props.item.description"
                            class="focus:placeholder-gray-300 text-gray-800 placeholder-gray-400 "
                            id="description"
                        />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="project_name" value="Project" />
                        <Listbox v-model="selectedProject">
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative cursor-default text-left px-3 py-1.5 w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50"
                                >
                                    <span class="block truncate">{{ selectedProject.name }}</span>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                    >
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition
                                    leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <ListboxOptions
                                        class="absolute z-10 max-h-60 w-full overflow-auto bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                    >
                                        <ListboxOption
                                            v-slot="{ active, selected }"
                                            v-for="project in $page.props.projects"
                                            :key="project.id"
                                            :value="project"
                                            as="template"
                                        >
                                            <li
                                                :class="[
                                                active ? 'bg-gray-50 text-blue-800' : 'text-gray-800',
                                                'relative cursor-default select-none py-2 pl-10 pr-4',
                                                ]"
                                            >
                                                <span
                                                    :class="[
                                                    selected ? 'font-medium' : 'font-normal',
                                                    'block truncate',
                                                ]"
                                                >
                                                    {{ project.name }}
                                                </span>
                                                <span
                                                    v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-800"
                                                >
                                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="account_name" value="Account" />
                        <JetInput
                            type="text"
                            :value="$page.props.item.account_name"
                            id="account_name"
                            disabled
                        />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="status" value="Status" />
                        <Listbox v-model="selectedStatus">
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative cursor-default text-left px-3 py-1.5 w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50"
                                >
                                    <span class="block truncate">{{ selectedStatus.name }}</span>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                    >
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition
                                    leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <ListboxOptions
                                        class="absolute z-10 max-h-60 w-full overflow-auto bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                    >
                                        <ListboxOption
                                            v-slot="{ active, selected }"
                                            v-for="status in statuses"
                                            :key="status.id"
                                            :value="status"
                                            as="template"
                                        >
                                            <li
                                                :class="[
                                                active ? 'bg-gray-50 text-blue-800' : 'text-gray-800',
                                                'relative cursor-default select-none py-2 pl-10 pr-4',
                                                ]"
                                            >
                                                <span
                                                    :class="[
                                                    selected ? 'font-medium' : 'font-normal',
                                                    'block truncate',
                                                ]"
                                                >
                                                    {{ status.name }}
                                                </span>
                                                <span
                                                    v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-800"
                                                >
                                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="priority" value="Priority" />
                        <Listbox v-model="selectedPriority">
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative cursor-default text-left px-3 py-1.5 w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50"
                                >
                                    <span class="block truncate">{{ selectedPriority.name }}</span>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                    >
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition
                                    leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <ListboxOptions
                                        class="absolute z-10 max-h-60 w-full overflow-auto bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                    >
                                        <ListboxOption
                                            v-slot="{ active, selected }"
                                            v-for="priority in priorities"
                                            :key="priority.id"
                                            :value="priority"
                                            as="template"
                                        >
                                            <li
                                                :class="[
                                                active ? 'bg-gray-50 text-blue-800' : 'text-gray-800',
                                                'relative cursor-default select-none py-2 pl-10 pr-4',
                                                ]"
                                            >
                                                <span
                                                    :class="[
                                                    selected ? 'font-medium' : 'font-normal',
                                                    'block truncate',
                                                ]"
                                                >
                                                    {{ priority.name }}
                                                </span>
                                                <span
                                                    v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-800"
                                                >
                                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="start_date" value="Start Date" />
                        <JetInput
                            type="date"
                            :value="$page.props.item.start_date"
                            id="start_date"
                        />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="due_date" value="Due Date" />
                        <JetInput
                            type="date"
                            :value="$page.props.item.due_date"
                            id="due_date"
                        />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="tracked" value="Tracked" />
                        <JetInput
                            type="number"
                            :value="$page.props.item.tracked"
                            id="tracked"
                            step="0.5"
                        />
                    </div>
                    <div class="col-span-2">
                        <JetLabel for="estimated" value="Estimated" />
                        <JetInput
                            type="number"
                            :value="$page.props.item.estimated"
                            id="estimated"
                            step="0.5"
                        />
                    </div>
                    <div class="col-span-1 text-xs">
                        <p class="px-4 font-bold text-gray-600">
                            Created At
                        </p>
                        <span class="px-4 py-2 w-full">
                            {{ moment($page.props.item.created_at).format("DD/MM/YYYY") }}
                        </span>
                    </div>
                    <div class="col-span-1 text-xs">
                        <p class="px-4 font-bold text-gray-600">
                            Created By
                        </p>
                        <span class="px-4 py-2 w-full">
                            {{ moment($page.props.item.created_by).format("DD/MM/YYYY") }}
                        </span>
                    </div>
                    <div class="col-span-1 text-xs">
                        <p class="px-4 font-bold text-gray-600">
                            Updated At
                        </p>
                        <span class="px-4 py-2 w-full"
                              :class="{ 'text-gray-600': !$page.props.item.updated_at }"
                        >
                            {{ $page.props.item.updated_at ? moment($page.props.item.updated_at).format("DD/MM/YYYY") : '' }}
                        </span>
                    </div>
                    <div class="col-span-1 text-xs">
                        <p class="px-4 font-bold text-gray-600">
                            Updated By
                        </p>
                        <span class="px-4 py-2 w-full"
                              :class="{ 'text-gray-600': !$page.props.item.updated_by }"
                        >
                            {{ $page.props.item.updated_by ? $page.props.item.updated_by : '' }}
                        </span>
                    </div>
                </div>
                <div class="w-full border-t border-gray-200 py-4">
                    <FileSection />
                </div>
                <div class="w-full border-t border-gray-200 py-4">
                    <ActivitySection />
                </div>
            </div>
            <div class="col-span-1 border-l border-gray-200">
                <CommentSection />
            </div>
        </div>
    </AppLayout>
</template>
