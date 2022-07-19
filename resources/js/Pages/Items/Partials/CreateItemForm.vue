<script setup>
import { ref } from "vue";
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetInput from '@/Jetstream/Input.vue';
import Textarea from '@/Shared/Textarea.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import ModalFormSection from '@/Shared/ModalFormSection.vue';
import moment from "moment";
import { CheckIcon, SelectorIcon } from '@heroicons/vue/outline'
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'

const props = defineProps({
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
    name: '',
    description: '',
    user_id: selectedUser.value['id'],
    project_id: selectedProject.value['id'],
    status_id: selectedStatus.value['id'],
    priority_id: selectedPriority.value['id'],
    start_date: '',
    due_date: '',
    tracked: '',
    estimated: '',
    created_at: moment().format('DD-MM-YYYY'),
});

const emit = defineEmits(['exit', true]);

const close = () => {
    emit('exit');
}

const createItem = () => {
    form.post(route('item.store'), {
        errorBag: 'createItem',
        preserveScroll: true,
        onSuccess: () => emit('exit'),
    });
};
</script>

<template>
    <ModalFormSection @submitted="createItem">
        <template #form>
            <div class="col-span-6">
                <JetLabel for="name" value="Name" />
                <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full border-gray-200"
                    autofocus />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetLabel for="description" value="Description" />
                <Textarea id="description" v-model="form.description" type="textarea"
                    class="mt-1 block w-full border-gray-200" />
                <JetInputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetLabel for="user_id" value="User ID" />
                <Listbox v-model="selectedUser">
                    <div class="relative mt-1">
                        <ListboxButton
                            class="relative w-full cursor-default border border-gray-200 rounded-md bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="block truncate">{{ selectedUser.name }}</span>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </span>
                        </ListboxButton>

                        <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
                            leave-to-class="opacity-0">
                            <ListboxOptions
                                class="z-50 absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                <ListboxOption v-slot="{ active, selected }" v-for="singular_user in $page.props.users"
                                    :key="singular_user.id" :value="singular_user" as="template">
                                    <li :class="[
                                        active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
                                        'relative cursor-default select-none py-2 pl-10 pr-4',
                                    ]">
                                        <span :class="[
                                            selected ? 'font-medium' : 'font-normal',
                                            'block truncate',
                                        ]">
                                            {{ singular_user.name }}
                                        </span>
                                        <span v-if="selected"
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600">
                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </li>
                                </ListboxOption>
                            </ListboxOptions>
                        </transition>
                    </div>
                </Listbox>
                <JetInputError :message="form.errors.user_id" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetLabel for="project_id" value="Project" />
                <Listbox v-model="selectedProject">
                    <div class="relative mt-1">
                        <ListboxButton
                            class="relative w-full cursor-default border border-gray-200 rounded-md bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="block truncate">{{ selectedProject.name }}</span>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </span>
                        </ListboxButton>

                        <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
                            leave-to-class="opacity-0">
                            <ListboxOptions
                                class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                <ListboxOption v-slot="{ active, selected }" v-for="project in $page.props.projects"
                                    :key="project.id" :value="project" as="template">
                                    <li :class="[
                                        active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
                                        'relative cursor-default select-none py-2 pl-10 pr-4',
                                    ]">
                                        <span :class="[
                                            selected ? 'font-medium' : 'font-normal',
                                            'block truncate',
                                        ]">
                                            {{ project.name }}
                                        </span>
                                        <span v-if="selected"
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600">
                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </li>
                                </ListboxOption>
                            </ListboxOptions>
                        </transition>
                    </div>
                </Listbox>
                <JetInputError :message="form.errors.project_id" class="mt-2" />
            </div>

            <div class="col-span-6">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="status" value="Status" />
                        <Listbox v-model="selectedStatus">
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative cursor-default text-left px-3 py-1.5 w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50">
                                    <span class="block truncate">{{ selectedStatus.name }}</span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions
                                        class="absolute max-h-60 w-full overflow-auto bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                        <ListboxOption v-slot="{ active, selected }"
                                            v-for="status in $page.props.statuses" :key="status.id" :value="status"
                                            as="template">
                                            <li :class="[
                                                active ? 'bg-gray-50 text-blue-800' : 'text-gray-800',
                                                'relative cursor-default select-none py-2 pl-10 pr-4',
                                            ]">
                                                <span :class="[
                                                    selected ? 'font-medium' : 'font-normal',
                                                    'block truncate',
                                                ]">
                                                    {{ status.name }}
                                                </span>
                                                <span v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-800">
                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
                        <JetInputError :message="form.errors.status" class="mt-2" />
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="priority" value="Priority" />
                        <Listbox v-model="selectedPriority">
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative cursor-default text-left px-3 py-1.5 w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50">
                                    <span class="block truncate">{{ selectedPriority.name }}</span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions
                                        class="absolute max-h-60 w-full overflow-auto bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                        <ListboxOption v-slot="{ active, selected }"
                                            v-for="priority in $page.props.priorities" :key="priority.id"
                                            :value="priority" as="template">
                                            <li :class="[
                                                active ? 'bg-gray-50 text-blue-800' : 'text-gray-800',
                                                'relative cursor-default select-none py-2 pl-10 pr-4',
                                            ]">
                                                <span :class="[
                                                    selected ? 'font-medium' : 'font-normal',
                                                    'block truncate',
                                                ]">
                                                    {{ priority.name }}
                                                </span>
                                                <span v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-800">
                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
                        <JetInputError :message="form.errors.priority" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="start_date" value="Start Date" />
                        <JetInput id="start_date" v-model="form.start_date" type="date"
                            class="mt-1 block w-full border-gray-200" />
                        <JetInputError :message="form.errors.start_date" class="mt-2" />
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="due_date" value="Due Date" />
                        <JetInput id="due_date" v-model="form.due_date" type="date"
                            class="mt-1 block w-full border-gray-200" />
                        <JetInputError :message="form.errors.due_date" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="tracked" value="Tracked" />
                        <JetInput id="tracked" v-model="form.tracked" type="number"
                            class="mt-1 block w-full border-gray-200" />
                        <JetInputError :message="form.errors.tracked" class="mt-2" />
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="estimated" value="Estimated" />
                        <JetInput id="estimated" v-model="form.estimated" type="number"
                            class="mt-1 block w-full border-gray-200" />
                        <JetInputError :message="form.errors.estimated" class="mt-2" />
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>

            <JetSecondaryButton @click="close" class="mr-3">
                Cancel
            </JetSecondaryButton>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </JetButton>
        </template>
    </ModalFormSection>
</template>
