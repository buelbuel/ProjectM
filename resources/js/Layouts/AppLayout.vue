<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <JetBanner />

        <div class="bg-base-200">
            <!-- Page Navigation -->
            <nav class="navbar bg-base-100">
                <div class="navbar-start">
                    <div class="dropdown">
                        <label tabindex="0" class="btn btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                        </label>
                        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow-lg bg-base-100 w-52">
                            <li><Link :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</Link></li>
                            <li><Link :href="route('reports')" :active="route().current('reports')">Reports</Link></li>
                            <li><Link :href="route('items.index')" :active="route().current('items.index')">Items</Link></li>
                            <li><Link :href="route('projects.index')" :active="route().current('projects.index')">Projects</Link></li>
                            <li><Link :href="route('accounts.index')" :active="route().current('accounts.index')">Accounts</Link></li>
                            <li><Link :href="route('contacts.index')" :active="route().current('contacts.index')">Contacts</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="navbar-center">
                    <Link :href="route('dashboard')" class="btn btn-ghost">
                        <JetApplicationMark class="block h-9 w-auto" />
                    </Link>
                </div>
                <div class="navbar-end">
                    <button class="btn btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                    <button class="btn btn-ghost">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            <span class="badge badge-xs badge-primary indicator-item"></span>
                        </div>
                    </button>
                    <div class="dropdown dropdown-left">
                        <button class="btn btn-ghost">
                            <div class="avatar mask mask-squircle w-8 h-8">
                                <img
                                    v-if="$page.props.jetstream.managesProfilePhotos"
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name"
                                />
                                <span v-else class="inline-flex rounded-md">
                                <div class="bg-secondary inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ $page.props.user.name }}

                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </span>
                            </div>
                        </button>

                        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow-lg bg-base-100 w-52">
                            <li class="menu-title"><span>{{ $page.props.user.name }}</span></li>
                            <li><Link :href="route('profile.show')" :active="route().current('profile.show')">Profile</Link></li>
                            <template v-if="$page.props.jetstream.hasApiFeatures">
                                <li><Link :href="route('api-tokens.index')">API Tokens</Link></li>
                            </template>
                            <form @submit.prevent="logout">
                                <JetDropdownLink as="button"> <!-- Todo: change from jet -->
                                    Log Out
                                </JetDropdownLink>
                            </form>
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <li class="menu-title mt-4"><span>Manage Team</span></li>
                                <li><Link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">Team Settings</Link></li>
                                <template v-if="$page.props.jetstream.canCreateTeams">
                                    <li><Link :href="route('teams.create')" :active="route().current('teams.create')">Create New Team</Link></li>
                                </template>
                                <li class="menu-title mt-4"><span>Switch Teams</span></li>
                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <JetDropdownLink as="button"> <!-- Todo: change from jet -->
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="team.id == $page.props.user.current_team_id"
                                                    class="mr-2 h-5 w-5 text-green-400"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </JetDropdownLink>
                                    </form>
                                </template>
                            </template>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-base-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="min-h-screen">
                <slot />
            </main>

            <!-- Page Footer -->
            <footer class="footer footer-center p-10 mt-10 bg-primary text-primary-content">
                <div>
                    <svg width="50" height="50" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" class="inline-block fill-current"><path d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"></path></svg>
                    <p class="font-bold">
                    ACME Industries Ltd. <br>Providing reliable tech since 1992
                    </p> 
                    <p>Copyright © 2022 - All right reserved</p>
                </div>
            </footer>
        </div>
    </div>
</template>
