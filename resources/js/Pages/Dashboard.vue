<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {
        Head,
        useForm,
        usePage,
    } from '@inertiajs/vue3';
    import {
        ref
    } from 'vue';

    const props = defineProps({
        likeMinded: {
            type: Object,
            required: true,
        },
        friendRequests: {
            type: Object,
            required: true,
        },
    });

    const requestSendForm = useForm({
        receiver_id: null,
    });

    const requestAcceptForm = useForm({
        request_id: null,
    });


    const {
        props: pageProps
    } = usePage();

    const filterGender = ref('both');

    const sendRequest = (receiverId) => {
        requestSendForm.receiver_id = receiverId;

        requestSendForm.post(route('friend-request.send'), {
            onSuccess: () => {
                alert('Friend request sent successfully.');
            },
            onError: () => {
                alert('An error occurred while sending the friend request.');
            },
        });
    };

    const acceptRequest = (request_id) => {
        requestAcceptForm.request_id = request_id;

        requestAcceptForm.post(route('friend-requests.accept'), {
            onSuccess: () => {
                alert('Friend request accepted successfully.');
            },
            onError: () => {
                alert('An error occurred while accepted the friend request.');
            },
        });
    };

</script>

<template>

    <Head title="Timeline" />

    <AuthenticatedLayout>
        <div class="h-screen grid grid-cols-1 md:grid-cols-4 container mx-auto">
            <!-- Left Column: Requests Section -->
            <div class="bg-gray-100 p-6 border-r hidden md:block">
                <div class="text-xl font-semibold text-gray-800 mb-4">Requests You Receive</div>
                <!-- Request items -->
                <ul v-if="friendRequests.length > 0" class="space-y-4">
                    <li v-for="request in friendRequests" :key="request.id"
                        class="bg-white p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img :src="request.sender.profile_image || 'https://via.placeholder.com/40x40.png'"
                                alt="User Image" class="w-10 h-10 rounded-full" />
                            <div>
                                <p class="text-gray-800 font-semibold">{{ request . sender . name }}</p>
                                <p class="text-sm text-gray-600">Sent
                                    {{ new Date(request . created_at) . toLocaleString() }}</p>
                            </div>
                        </div>
                        <button @click="acceptRequest(request.id)"
                            class="inline-flex items-center p-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Accept
                        </button>
                    </li>
                </ul>
                <p v-else class="bg-white p-4 rounded-lg shadow-md text-center text-gray-600">No friend requests you
                    have yet.</p>
            </div>

            <!-- Middle Column: Your Content (Search and User Card) -->
            <div class="col-span-2 flex items-center flex-col px-4 py-5 md:py-0 md:px-12">
                <!-- Search Bar -->
                <section class="py-5 w-full max-w-lg">
                    <div class="relative">
                        <input type="search" name="search" id="search" placeholder="Search..."
                            class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute top-1/2 left-3 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 16h4v-4h3l-5-5-5 5h3v4z" />
                        </svg>
                    </div>
                </section>

                <!-- User Card -->
                <section class="my-5 w-full max-w-lg overflow-y-scroll" style="max-height: 80vh;">
                    <div v-for="individual in likeMinded" :key="individual.id"
                        class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <a href="#" class="text-2xl font-semibold text-gray-800 hover:no-underline">
                                {{ individual . user . name }}
                            </a>
                        </div>
                        <div class="p-5">
                            <img :src="individual.image" alt="User Image"
                                class="w-full h-96 object-cover rounded-lg mb-6" />
                        </div>
                        <div class="px-6 py-4">
                            <form>
                                <button @click.prevent="sendRequest(individual.id)"
                                    class="inline-flex items-center p-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>

                </section>
            </div>

            <!-- Right Column: Filters Section -->
            <div class="bg-gray-100 p-6 border-l hidden md:block">
                <div class="text-xl font-semibold text-gray-800 mb-4">Filters</div>
                <!-- Filters -->
                <div class="space-y-4 p-4 border rounded-lg shadow-md bg-white max-w-sm">
                    <h2 class="text-lg font-semibold text-gray-800">Select People</h2>
                    <div>
                        <div class="flex items-center">
                            <input type="radio" name="category" id="both" value="Both" v-model="filterGender"
                                checked
                                class="mr-3 w-5 h-5 text-blue-500 border-gray-300 focus:ring-blue-400 focus:ring-2 rounded" />
                            <label for="both" class="text-gray-700 font-medium hover:text-blue-500 cursor-pointer">
                                Both
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="category" id="male" value="Male" v-model="filterGender"
                                class="mr-3 w-5 h-5 text-blue-500 border-gray-300 focus:ring-blue-400 focus:ring-2 rounded" />
                            <label for="male" class="text-gray-700 font-medium hover:text-blue-500 cursor-pointer">
                                Male
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="category" id="female" value="Female" v-model="filterGender"
                                class="mr-3 w-5 h-5 text-blue-500 border-gray-300 focus:ring-blue-400 focus:ring-2 rounded" />
                            <label for="female" class="text-gray-700 font-medium hover:text-blue-500 cursor-pointer">
                                Female
                            </label>
                        </div>
                    </div>
                    <div class="mt-4 text-gray-800">
                        <p class="font-medium">
                            Selected: <span id="selected-category" class="text-blue-600">{{ filterGender }}</span>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
