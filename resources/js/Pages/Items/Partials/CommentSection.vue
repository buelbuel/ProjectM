<script setup>
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import moment from "moment";

const comments = [
    {
        number: "eNjas2",
        description: "Can be verified on any platform using docker",
        user: "Alicem Bülbül",
        date: moment(),
    },
    {
        number: "eNjas2",
        description: "Discover users and define teams to test for production readiness.",
        user: "Alicem Bülbül",
        date: moment(),
    },
    {
        number: "eNjas2",
        description: "To create new data record or structure use the Quick Add window which you can open from any screen by clicking the \"Add\" icon in the navigation bar.",
        user: "Alicem Bülbül",
        date: moment(),
    },
    {
        number: "eNjas2",
        description: "Can be verified on any platform using docker",
        user: "Alicem Bülbül",
        date: moment(),
    },
]
</script>

<template>
    <div class="px-4">
        <div class="flex-1 justify-between flex flex-col">
            <div class="flex flex-col space-y-4 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch text-sm">
                <!--div class="text-center text-gray-400 row-span-5 overflow-y-auto">
                    No comments yet.
                </div-->
                <template v-for="comment in comments" :key="comment.number">
                    <div class="px-4 py-2 bg-gray-50 border border-gray-200 hover:border-blue-600 text-gray-800 flex flex-col space-y-2 order-2 items-start">
                        <span class="text-justify">
                            {{ comment.description }}
                        </span>

                        <div class="inline-flex w-full justify-end space-x-2 text-xs text-gray-500">
                            <a href="#" class="hover:text-blue-600 font-bold">
                                {{ comment.user }}
                            </a>
                            <span>
                                {{ moment(comment.date).format('DD/MM/YYYY') }}
                            </span>
                        </div>
                    </div>
                </template>
            </div>
            <div class="border-t border-gray-200 pt-4 mt-4">
                    <textarea
                        placeholder="Write a comment."
                        class="w-full mb-4 focus:placeholder-gray-300 text-gray-800 placeholder-gray-400 text-sm"
                    />
                    <JetButton type="button">
                        Send
                    </JetButton>
            </div>
        </div>
    </div>
</template>
