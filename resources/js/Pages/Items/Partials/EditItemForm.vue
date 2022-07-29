<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import moment from "moment";

const form = useForm({
    id: '',
    name: '',
    description: '',
    user_id: '',
    project_id: '',
    status: '',
    priority: '',
    start_date: '',
    due_date: '',
    tracked: '',
    estimated: '',
    created_at: '',
    updated_at: moment().format('DD-MM-YYYY'),
});

const emit = defineEmits(['exit', true]);

const close = () => {
    emit('exit');
}

const editItem = () => {
    form.post(route('item.update'), {
        errorBag: 'editItem',
        preserveScroll: true,
        onSuccess: () => emit('exit'),
    });
};
</script>

<template>
    <JetFormSection @submitted="editItem">
        <template #title>
            Edit Item
        </template>

        <template #description>
            Provide all necessary information. Save & New will give you the option to create another Item with a blank form.
        </template>

        <template #form>
            <div class="col-span-6">
                <JetLabel for="name" value="Name" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetLabel for="description" value="Description" />
                <textarea
                    id="description"
                    v-model="form.description"
                    type="textarea"
                    class="mt-1 block w-full"
                />
                <JetInputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetLabel for="user_id" value="User ID" />
                <JetInput
                    id="user_id"
                    v-model="form.user_id"
                    type="text"
                    class="mt-1 block w-full"
                />
                <JetInputError :message="form.errors.user_id" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetLabel for="project_id" value="Project ID" />
                <JetInput
                    id="project_id"
                    v-model="form.project_id"
                    type="text"
                    class="mt-1 block w-full"
                />
                <JetInputError :message="form.errors.project_id" class="mt-2" />
            </div>

            <div class="col-span-6">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="status" value="Status" />
                        <JetInput
                            id="account_id"
                            v-model="form.status"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.status" class="mt-2" />
                    </div>

                            <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="priority" value="Priority" />
                        <JetInput
                            id="account_id"
                            v-model="form.priority"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.priority" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="start_date" value="Start Date" />
                        <JetInput
                            id="start_date"
                            v-model="form.start_date"
                            type="date"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.start_date" class="mt-2" />
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="due_date" value="Due Date" />
                        <JetInput
                            id="due_date"
                            v-model="form.due_date"
                            type="date"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.due_date" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="tracked" value="Tracked" />
                        <JetInput
                            id="tracked"
                            v-model="form.tracked"
                            type="number"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.tracked" class="mt-2" />
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <JetLabel for="estimated" value="Estimated" />
                        <JetInput
                            id="estimated"
                            v-model="form.estimated"
                            type="number"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.estimated" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <JetLabel for="created_at" value="Created At" />
                <JetInput
                    id="password_confirmation"
                    v-model="form.created_at"
                    type="date"
                    class="mt-1 block w-full"
                    disabled
                />
                <JetInputError :message="form.errors.created_at" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>

            <Link :href="route('items.index')"
                  class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md
                  font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                  focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-3"
            >
                Cancel
            </Link>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save & New
            </JetButton>
        </template>
    </JetFormSection>
</template>
